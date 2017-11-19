<?php

namespace alphayax\utils\cli;

use alphayax\utils\cli\exception\MissingArgException;
use alphayax\utils\cli\model\Help;
use alphayax\utils\cli\model\Option;
use alphayax\utils\cli\model\OptionList;


/**
 * Class GetOpt
 * @package alphayax\utils
 */
class GetOpt
{
    /** @var array Required options */
    protected $requiredOpt = [];

    /** @var OptionList : List of options */
    protected $options;

    /** @var string */
    protected $description;

    /** @var \alphayax\utils\cli\model\Help */
    protected $help;

    /** @var array Args passed to the script */
    private $opt_x = [];

    /**
     * GetOpt constructor.
     * Add the -h and --help options
     */
    public function __construct()
    {
        $this->help = new Help();
        $this->options = new OptionList();
        $this->options->add(new Option('h', 'help', 'Display help'));
    }

    /**
     * Add a long opt (name)
     * @param            $optName
     * @param            $optDesc
     * @param bool|false $hasValue
     * @param bool|false $isRequired
     * @return \alphayax\utils\cli\model\Option
     */
    public function addLongOpt($optName, $optDesc, $hasValue = false, $isRequired = false)
    {
        return $this->addOpt('', $optName, $optDesc, $hasValue, $isRequired);
    }

    /**
     * Add a short opt (letter)
     * @param            $optLetter
     * @param            $optDesc
     * @param bool|false $hasValue
     * @param bool|false $isRequired
     * @return \alphayax\utils\cli\model\Option
     */
    public function addShortOpt($optLetter, $optDesc, $hasValue = false, $isRequired = false)
    {
        return $this->addOpt($optLetter, '', $optDesc, $hasValue, $isRequired);
    }

    /**
     * Add an opt (letter + name)
     * @param $optLetter
     * @param $optName
     * @param $optDesc
     * @param $hasValue
     * @param $isRequired
     * @return \alphayax\utils\cli\model\Option
     */
    public function addOpt($optLetter, $optName, $optDesc, $hasValue = false, $isRequired = false)
    {
        $option = new Option($optLetter, $optName, $optDesc, $hasValue, $isRequired);
        $this->options->add($option);

        return $option;
    }

    /**
     * Parse the args given to the script
     * Display help if -h or --help option have been specified
     * Throw an exception if required options have not been provided
     * @throws \alphayax\utils\cli\exception\MissingArgException
     */
    public function parse()
    {
        /// Parse args
        $this->opt_x = getopt($this->options->serializeShortOpts(), $this->options->serializeLongOpts());

        /// Check required fields
        $this->checkRequiredOptions();

        /// If help flag have been specified, display help and exit
        if ($this->hasOptionName('h') || $this->hasOptionName('help')) {
            $this->help->display($this->options);
            exit(0);
        }
    }

    /**
     * @throws \alphayax\utils\cli\exception\MissingArgException
     */
    private function checkRequiredOptions()
    {
        $providedOpts = array_keys($this->opt_x);
        $requiredOpts = $this->options->getRequiredOpts();

        $missingOpts = [];
        foreach ($requiredOpts as $requiredOpt) {
            if ( ! in_array($requiredOpt->getShortOpt(), $providedOpts)
                && ! in_array($requiredOpt->getLongOpt(), $providedOpts)) {
                $missingOpts[] = $requiredOpt;
            }
        }


        /// If required fields are missing, throw an exception
        if ( ! empty($missingOpts)) {
            $exception = new MissingArgException();
            $exception->setMissingArgs($missingOpts);
            $exception->setProvidedArgs($providedOpts);
            $exception->setRequiredArgs($requiredOpts);
            throw $exception;
        }
    }

    /**
     * Return the value of a specific option
     * @param $optionName
     * @return mixed
     */
    public function getValueName($optionName)
    {
        return @$this->opt_x[$optionName];
    }

    /**
     * Return the value of a specific option
     * @param Option $option
     * @return mixed
     */
    public function getValue(Option $option)
    {
        return @$this->opt_x[$option->getShortOpt()] ?: @$this->opt_x[$option->getLongOpt()];
    }

    /**
     * Return true if the option have been specified in script args
     * @param $optionName
     * @return bool
     */
    public function hasOptionName($optionName)
    {
        return array_key_exists($optionName, $this->opt_x);
    }

    /**
     * Return true if the option have been specified in script args
     * @param Option $option
     * @return bool
     */
    public function hasOption(Option $option)
    {
        return array_key_exists($option->getLongOpt(), $this->opt_x)
            || array_key_exists($option->getShortOpt(), $this->opt_x);
    }

    /**
     * @param $description
     */
    public function setDescription($description)
    {
        $this->help->setDescription($description);
    }

}
