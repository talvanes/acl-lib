<?php namespace Talba\AclLib\Models;

class Role
{
    protected $id;
    protected $name;

    /**
     * Role constructor.
     *
     * @public
     * @param string $name Role name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Sets the role name.
     *
     * @param  string   $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets the role name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the role id.
     *
     * @return integer
     */
    public function getId()
    {
        return intval($this->id);
    }
}
