<?php

namespace alphayax\utils\cli;

use alphayax\utils\cli\exception\MissingArgException;
use alphayax\utils\cli\model\Help;
use alphayax\utils\cli\model\Option;
use alphayax\utils\cli\model\OptionList;
use alphayax\utils\cli\pattern\SingletonTrait;


/**
 * Class GetOpt
 * @package alphayax\utils
 */
class GetOpt
{
    use SingletonTrait;

    /** @var array Required options */
    protected $requiredOpt = [];

    /** @var OptionList : List of options */
    protected $options;

    /** @var string */
    protected $description;

    /** @var \alphayax\utils\cli\model\Help */
    protected $help;

    /**
     * GetOpt constructor.
     * Add the -h and --help options
     */
    protected function __construct()
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
     * @throws \alphayax\utils\cli\exception\ConflictException
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
     * @throws \alphayax\utils\cli\exception\ConflictException
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
     * @throws \alphayax\utils\cli\exception\ConflictException
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
     * Print help and exit if required args are missing
     */
    public function parse()
    {
        /// Parse args
        $this->options->parse();

        /// Basic checks
        $this->checkForHelp();
        $this->checkRequiredOpts();
    }

    /**
     * If help flag have been specified, display help and exit
     */
    protected function checkForHelp()
    {
        try {
            if ($this->options->getFromLongOptName('help')->isPresent()) {
                $this->help->display($this->options);
                exit(0);
            }
        } catch (exception\UndefinedOptionException $e) {

        }
    }

    /**
     * Check if all required parameters are present
     */
    protected function checkRequiredOpts()
    {
        try {
            $this->options->checkRequiredOptions();
        } catch (MissingArgException $e) {

            echo "ERROR : Required parameters are missing.". PHP_EOL;
            echo "Please specify :". PHP_EOL;
            $requiredArgs = $e->getRequiredArgs();
            foreach ( $requiredArgs as $requiredArg){

                $ReqArgLine = '';

                if ($requiredArg->hasShortOpt()) {
                    $ReqArgLine .= '-' . $requiredArg->getShortOpt();
                }
                else {
                    $ReqArgLine .= '--' . $requiredArg->getLongOpt();
                }

                echo "\t". $ReqArgLine . "\t" . $requiredArg->getDescription() . PHP_EOL;
            }
            echo "". PHP_EOL;
            $this->help->display($this->options);
            exit(1);
        }
    }

    /**
     * Return the value of a specific option
     * @param string $optionName
     * @return string
     * @throws \alphayax\utils\cli\exception\UndefinedOptionException
     */
    public function getValueName($optionName)
    {
        return $this->options->getFromOptName($optionName)->getValue();
    }

    /**
     * Return true if the option have been specified in script args
     * @param string $optionName
     * @return bool
     * @throws \alphayax\utils\cli\exception\UndefinedOptionException
     */
    public function hasOptionName($optionName)
    {
        return $this->options->getFromOptName($optionName)->isPresent();
    }

    /**
     * @param $description
     */
    public function setDescription($description)
    {
        $this->help->setDescription($description);
    }

}
