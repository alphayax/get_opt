<?php

namespace alphayax\utils\cli\model;

/**
 * Class Option
 * @package alphayax\utils\cli\model
 */
class Option
{
    /** @var string Short opt name (eg: v) */
    protected $shortOpt = '';

    /** @var string Long opt name (eg: verbose) */
    protected $longOpt = '';

    /** @var string Opt description */
    protected $description = '';

    /** @var bool Opt is required */
    protected $isRequired = false;

    /** @var bool Opt has value associated */
    protected $askValue = false;

    /** @var bool Parsed presence of the variable */
    protected $isPresent = false;

    /** @var string|array Parsed value of the option */
    protected $value = '';

    /**
     * Option constructor.
     * @param string $optShortName
     * @param string $optLongName
     * @param string $optDesc
     * @param bool   $askValue Define if the option need an associated value (eg: -n <value>)
     * @param bool   $isRequired
     */
    function __construct($optShortName = '', $optLongName = '', $optDesc = '', $askValue = false, $isRequired = false)
    {
        $this->shortOpt = $optShortName;
        $this->longOpt = $optLongName;
        $this->description = $optDesc;
        $this->askValue = $askValue;
        $this->isRequired = $isRequired;
    }

    /**
     * @return string
     */
    public function getShortOpt()
    {
        return $this->shortOpt;
    }

    /**
     * @return bool
     */
    public function hasShortOpt()
    {
        return ! empty($this->shortOpt);
    }

    /**
     * @return string
     */
    public function getLongOpt()
    {
        return $this->longOpt;
    }

    /**
     * @return bool
     */
    public function hasLongOpt()
    {
        return ! empty($this->longOpt);
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->isRequired;
    }

    /**
     * @return boolean
     */
    public function askValue()
    {
        return $this->askValue;
    }

    /**
     * @return bool
     */
    public function isPresent()
    {
        return $this->isPresent;
    }

    /**
     * @param bool $isPresent
     */
    public function setIsPresent($isPresent = true)
    {
        $this->isPresent = $isPresent;
    }

    /**
     * @return string|array
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string|array $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}
