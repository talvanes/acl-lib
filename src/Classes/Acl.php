<?php namespace AclLib\Classes;

final class Acl
{
    private $db;

    /**
     * Acl constructor.
     *
     * It manages users' roles and permissions.
     *
     * @public
     * @param \PDO $db Database connection
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }


    /**
     * Checks if user belongs to the role given.
     *
     * @param mixed  $user An AclLib\Models\User class instance
     * @param string $role Role name
     */
    public function is($user, $role)
    {
        // todo: implement method
    }

    /**
     * Checks if user has the permission given.
     *
     * @param mixed  $user       An AclLib\Models\User class instance
     * @param string $permission Permission label
     */
    public function can($user, $permission)
    {
        // todo: implement method
    }


    /**
     * Checks if the role has the permission given.
     *
     * @param mixed  $role       An AclLib\Models\Role class instance
     * @param string $permission Permission label
     */
    public function has($role, $permission)
    {
        // todo: implement method
    }
}
