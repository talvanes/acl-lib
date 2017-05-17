<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;

use Talba\AclLib\Classes\Acl;
use Talba\AclLib\Models\User;
use Talba\AclLib\Models\Role;
use Talba\AclLib\Models\Permission;

/**
 * Defines application features from the specific context.
 */
class AclContext implements Context
{
    protected $db;
    protected $acl;
    protected $user;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     *
     * @public
     * @param string $dsn      DB DSN
     * @param string $username DB username (default: root)
     * @param string $password DB password (default: '')
     */
    public function __construct($dsn, $username = 'root', $password = '')
    {
        // set up database connection
        $this->db = new \PDO($dsn, $username, $password, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        // start acl module
        $this->acl = new Acl($this->db);
    }


    public function __destruct()
    {
        // kill database connection
        $this->db = null;
    }


    /**
     * @BeforeScenario
     */
    public function beginTrans(BeforeScenarioScope $scope)
    {
        $this->db->beginTransaction();
    }

    /**
     * @AfterScenario
     */
    public function rollbackTrans(AfterScenarioScope $scope)
    {
        $this->db->rollBack();
    }


    /**
     * @Transform :user
     */
    public function castUsernameAsUser($user)
    {
        $selectStmt = $this->db->prepare("SELECT id, username, role_id as roleId FROM users WHERE username = :username");
        $selectStmt->execute([ 'username' => $user ]);
        return $selectStmt->fetchObject(User::class);
    }

    /**
     * @Transform :role
     */
    public function castRoleNameAsRole($role)
    {
        $selectStmt = $this->db->prepare("SELECT id, name FROM roles WHERE name = :role");
        $selectStmt->execute([ 'role' => $role ]);
        return $selectStmt->fetchObject(Role::class);
    }

    /**
     * @Transform :permission
     */
    public function castPermissionLabelAsPermission($permission)
    {
        $selectStmt = $this->db->prepare("SELECT id, label FROM permissions WHERE label = :permission");
        $selectStmt->execute([ 'permission' => $permission ]);
        return $selectStmt->fetchObject(Permission::class);
    }


    /**
     * @Given there are users:
     */
    public function thereAreUsers(TableNode $usersTable)
    {
        // prepare PDO statement for insert query
        $insertStmt = $this->db->prepare("INSERT INTO users (username) VALUES (:username)");

        // insert records into database
        foreach ($usersTable as $userData) {
            $insertStmt->execute([
                'username' => $userData['username'],
            ]);
        }
    }

    /**
     * @Given there are roles:
     */
    public function thereAreRoles(TableNode $rolesTable)
    {
        // prepare PDO statement for insert query
        $insertStmt = $this->db->prepare("INSERT INTO roles (name) VALUES (:roleName)");

        // insert records into database
        foreach ($rolesTable as $roleData) {
            $insertStmt->execute([
                'roleName' => $roleData['name'],
            ]);
        }
    }

    /**
     * @Given there are permissions:
     */
    public function thereArePermissions(TableNode $permissionsTable)
    {
        // prepare PDO statement for insert query
        $insertStmt = $this->db->prepare("INSERT INTO permissions (label) VALUES (:permission)");

        // insert records into database
        foreach ($permissionsTable as $permissionData) {
            $insertStmt->execute([
                'permission' => $permissionData['label'],
            ]);
        }
    }

    /**
     * @Given I am user :user
     */
    public function iAmUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @When I check if I belong to role :role
     */
    public function iCheckIfIBelongToRole(Role $role)
    {
        $this->user->is($role);
    }

    /**
     * @Then I should be granted access as :role
     */
    public function iShouldBeGrantedAccessAs(Role $role)
    {
        Assert::that($this->user->is($role))->true();
    }

    /**
     * @Given I belong to role :role
     */
    public function iBelongToRole(Role $role)
    {
        // user {$this->user} belongs to role {$role}
        $this->user->setRole($role);

        // update into object on "users" table
        $selectStmt = $this->db->prepare("SELECT * FROM users WHERE id = :userId");
        $selectStmt->setFetchMode(\PDO::FETCH_INTO, $this->user);
        $this->user = $selectStmt->fetch();
    }

    /**
     * @Then I should be denied access as :role
     */
    public function iShouldBeDeniedAccessAs(Role $role)
    {
        Assert::that($this->user->is($role))->false();
    }

    /**
     * @When I check if I have :permission permission
     */
    public function iCheckIfIHavePermission(Permission $permission)
    {
        $this->user->can($permission);
    }

    /**
     * @Then I should not perform :permission feature
     */
    public function iShouldNotPerformFeature(Permission $permission)
    {
        Assert::that($this->user->can($permission))->false();
    }

    /**
     * @Given I have :permission permission
     */
    public function iHavePermission(Permission $permission)
    {
        $insertStmt = $this->db->prepare("INSERT INTO user_permission (user_id, permission_id) VALUES (:userId, :permissionId)");
        $insertStmt->execute([
            'userId' => $this->user->getId(),
            'permissionId' => $permission->getId(),
        ]);
    }

    /**
     * @Then I should perform :permission feature
     */
    public function iShouldPerformFeature(Permission $permission)
    {
        Assert::that($this->user->can($permission))->true();
    }

    /**
     * @Given role :role has :permission feature
     */
    public function roleHasFeature(Role $role, Permission $permission)
    {
        $insertStmt = $this->db->prepare("INSERT INTO role_permission (role_id, permission_id) VALUES (:roleId, :permissionId)");
        $insertStmt->execute([
            'roleId' => $role->getId(),
            'permissionId' => $permission->getId(),
        ]);
    }
}
