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
     */
    public function addLongOpt($optName, $optDesc, $hasValue = false, $isRequired = false)
    {
        $this->addOpt('', $optName, $optDesc, $hasValue, $isRequired);
    }

    /**
     * Add a short opt (letter)
     * @param            $optLetter
     * @param            $optDesc
     * @param bool|false $hasValue
     * @param bool|false $isRequired
     */
    public function addShortOpt($optLetter, $optDesc, $hasValue = false, $isRequired = false)
    {
        $this->addOpt($optLetter, '', $optDesc, $hasValue, $isRequired);
    }

    /**
     * Add an opt (letter + name)
     * @param $optLetter
     * @param $optName
     * @param $optDesc
     * @param $hasValue
     * @param $isRequired
     */
    public function addOpt($optLetter, $optName, $optDesc, $hasValue = false, $isRequired = false)
    {
        $this->options->add(new Option($optLetter, $optName, $optDesc, $hasValue, $isRequired));
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
        $requiredOpts = $this->options->getRequiredOpts();
        $providedOpts = array_keys($this->opt_x);
        $missingOpts = array_diff($requiredOpts, $providedOpts);

        /// If help flag have been specified, display help and exit
        if ($this->hasOption('h') || $this->hasOption('help')) {
            $this->help->display($this->options);
            exit(0);
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
    public function getOptionValue($optionName)
    {
        return @$this->opt_x[$optionName];
    }

    /**
     * Return true if the option have been specified in script args
     * @param $optionName
     * @return bool
     */
    public function hasOption($optionName)
    {
        return array_key_exists($optionName, $this->opt_x);
    }

    /**
     * @param $description
     */
    public function setDescription($description)
    {
        $this->help->setDescription($description);
    }

}
