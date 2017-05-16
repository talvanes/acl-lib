<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;

/**
 * Defines application features from the specific context.
 */
class AclContext implements Context
{
    protected $db;
    protected $acl;

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
    public function __construct($dsn, $username, $password)
    {
        // set up database connection
        $this->db = new \PDO($dsn, $username, $password, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        // todo: start acl
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
     * @Given there are users:
     */
    public function thereAreUsers(TableNode $usersTable)
    {
        throw new PendingException();
    }

    /**
     * @Given there are roles:
     */
    public function thereAreRoles(TableNode $rolesTable)
    {
        throw new PendingException();
    }

    /**
     * @Given there are permissions:
     */
    public function thereArePermissions(TableNode $permissionsTable)
    {
        throw new PendingException();
    }

    /**
     * @Given I am user :user
     */
    public function iAmUser($user)
    {
        throw new PendingException();
    }

    /**
     * @When I check if I belong to role :role
     */
    public function iCheckIfIBelongToRole($role)
    {
        throw new PendingException();
    }

    /**
     * @Then I should be granted access as :role
     */
    public function iShouldBeGrantedAccessAs($role)
    {
        throw new PendingException();
    }

    /**
     * @Given I belong to role :role
     */
    public function iBelongToRole($role)
    {
        throw new PendingException();
    }

    /**
     * @Then I should be denied access as :role
     */
    public function iShouldBeDeniedAccessAs($role)
    {
        throw new PendingException();
    }

    /**
     * @When I check if I have :permission permission
     */
    public function iCheckIfIHavePermission($permission)
    {
        throw new PendingException();
    }

    /**
     * @Then I should not perform :permission feature
     */
    public function iShouldNotPerformFeature($permission)
    {
        throw new PendingException();
    }

    /**
     * @Given I have :permission permission
     */
    public function iHavePermission($permission)
    {
        throw new PendingException();
    }

    /**
     * @Then I should perform :permission feature
     */
    public function iShouldPerformFeature($permission)
    {
        throw new PendingException();
    }

    /**
     * @Given role :role has :permission feature
     */
    public function roleHasFeature($role, $permission)
    {
        throw new PendingException();
    }
}
