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
        return new User($user);
    }

    /**
     * @Transform :role
     */
    public function castRoleNameAsRole($role)
    {
        return new Role($role);
    }

    /**
     * @Transform :permission
     */
    public function castPermissionLabelAsPermission($permission)
    {
        return new Permission($permission);
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
        throw new PendingException();
    }

    /**
     * @When I check if I belong to role :role
     */
    public function iCheckIfIBelongToRole(Role $role)
    {
        throw new PendingException();
    }

    /**
     * @Then I should be granted access as :role
     */
    public function iShouldBeGrantedAccessAs(Role $role)
    {
        throw new PendingException();
    }

    /**
     * @Given I belong to role :role
     */
    public function iBelongToRole(Role $role)
    {
        throw new PendingException();
    }

    /**
     * @Then I should be denied access as :role
     */
    public function iShouldBeDeniedAccessAs(Role $role)
    {
        throw new PendingException();
    }

    /**
     * @When I check if I have :permission permission
     */
    public function iCheckIfIHavePermission(Permission $permission)
    {
        throw new PendingException();
    }

    /**
     * @Then I should not perform :permission feature
     */
    public function iShouldNotPerformFeature(Permission $permission)
    {
        throw new PendingException();
    }

    /**
     * @Given I have :permission permission
     */
    public function iHavePermission(Permission $permission)
    {
        throw new PendingException();
    }

    /**
     * @Then I should perform :permission feature
     */
    public function iShouldPerformFeature(Permission $permission)
    {
        throw new PendingException();
    }

    /**
     * @Given role :role has :permission feature
     */
    public function roleHasFeature(Role $role, Permission $permission)
    {
        throw new PendingException();
    }
}
