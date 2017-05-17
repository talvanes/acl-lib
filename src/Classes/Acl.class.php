<?php namespace Talba\AclLib\Classes;

use Talba\AclLib\Models\User;
use Talba\AclLib\Models\Role;
use Talba\AclLib\Models\Permission;

final class Acl
{
    private $db;

    /**
     * Acl constructor.
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
     * @param mixed  $user A Talba\AclLib\Models\User class instance
     * @param string $role Role name
     */
    public function is(User $user, Role $role)
    {
        // todo: implement method
    }

    /**
     * Checks if user has the permission given.
     *
     * @param mixed  $user       A Talba\AclLib\Models\User class instance
     * @param string $permission Permission label
     */
    public function can(User $user, Permission $permission)
    {
        // todo: implement method
    }


    /**
     * Checks if the role has the permission given.
     *
     * @param mixed  $role       A Talba\AclLib\Models\Role class instance
     * @param string $permission Permission label
     */
    public function has(Role $role, Permission $permission)
    {
        // todo: implement method
    }
}
