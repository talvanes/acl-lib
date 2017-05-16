<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

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
}
