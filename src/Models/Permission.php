<?php namespace Talba\AclLib\Models;

class Permission
{
    protected $id;
    protected $label;

    /**
     * Permission constructor.
     *
     * @public
     * @param string $label
     */
    public function __construct($label)
    {
        $this->label = $label;
    }

    /**
     * Sets the permission label
     *
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Gets the permission label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Gets the permission id
     *
     * @return integer
     */
    public function getId()
    {
        return intval($this->id);
    }

}
