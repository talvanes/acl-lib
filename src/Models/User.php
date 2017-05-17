<?php namespace Talba\AclLib\Models;

class User
{
    protected $username;
    protected $roleId;
    protected $id;

    /**
     * User constructor
     *
     * @public
     * @param string  $username        User's login
     * @param Role [$role         = null] Role id
     */
    public function __construct($username, Role $role = null)
    {
        $this->username = $username;
        if (isset($role)) {
            $this->roleId = intval($role->id);
        }
    }

    /**
     * Sets the user's login.
     *
     * @param  string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Sets user role.
     *
     * @param Role  $role
     * @return $this
     */
    public function setRole(Role $role)
    {
        $this->roleId = intval($role->id);
        return $this;
    }

    /**
     * Gets the user's login.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Gets the user's id.
     * @return integer
     */
    public function getId()
    {
        return intval($this->id);
    }
}
