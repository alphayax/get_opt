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
    protected $hasValue = false;

    /**
     * Option constructor.
     * @param string $optShortName
     * @param string $optLongName
     * @param string $optDesc
     * @param bool   $hasValue
     * @param bool   $isRequired
     */
    function __construct($optShortName = '', $optLongName = '', $optDesc = '', $hasValue = false, $isRequired = false)
    {
        $this->shortOpt = $optShortName;
        $this->longOpt = $optLongName;
        $this->description = $optDesc;
        $this->hasValue = $hasValue;
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
    public function hasValue()
    {
        return $this->hasValue;
    }

}
