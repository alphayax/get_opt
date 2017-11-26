<?php

namespace alphayax\utils\cli\exception;

use alphayax\utils\cli\model\Option;

/**
 * Class MissingArgException
 * @package alphayax\utils\cli\exception
 */
class MissingArgException extends AbstractException
{
    /** @var Option[] List of missing Args */
    protected $missingArgs = [];

    /** @var string[] List of provided Args */
    protected $providedArgs = [];

    /** @var Option[] List of required Args */
    protected $requiredArgs = [];

    /**
     * MissingArgException constructor.
     * @param string     $string
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct($string = 'Required fields are missing', $code = 0, $previous = null)
    {
        parent::__construct($string, $code, $previous);
    }

    /**
     * @return Option[]
     */
    public function getMissingArgs()
    {
        return $this->missingArgs;
    }

    /**
     * @param Option[] $missingArgs
     */
    public function setMissingArgs($missingArgs)
    {
        $this->missingArgs = $missingArgs;

        $this->message .= ' : ( ';
        foreach ($missingArgs as $missingArg) {
            $this->message .= "[" .
                ($missingArg->hasShortOpt() ? ' -' . $missingArg->getShortOpt() : '') .
                ($missingArg->hasLongOpt() ? ' --' . $missingArg->getLongOpt() : '') .
                ']';
        }
        $this->message .= ' )';
    }

    /**
     * @return \string[]
     */
    public function getProvidedArgs()
    {
        return $this->providedArgs;
    }

    /**
     * @param \string[] $providedArgs
     */
    public function setProvidedArgs($providedArgs)
    {
        $this->providedArgs = $providedArgs;
    }

    /**
     * @return Option[]
     */
    public function getRequiredArgs()
    {
        return $this->requiredArgs;
    }

    /**
     * @param Option[] $requiredArgs
     */
    public function setRequiredArgs($requiredArgs)
    {
        $this->requiredArgs = $requiredArgs;
    }

}
