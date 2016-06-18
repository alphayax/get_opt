<?php
namespace alphayax\utils\cli\exception;

/**
 * Class MissingArgException
 * @package alphayax\utils\cli\exception
 */
class MissingArgException extends \Exception {

    /** @var string[] List of missing Args */
    protected $missingArgs = [];

    /** @var string[] List of provided Args */
    protected $providedArgs = [];

    /** @var string[] List of required Args */
    protected $requiredArgs = [];

    /**
     * MissingArgException constructor.
     * @param string     $string
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct( $string = 'Required fields are missing', $code = 0, $previous = null) {
        parent::__construct( $string, $code, $previous);
    }

    /**
     * @return \string[]
     */
    public function getMissingArgs() {
        return $this->missingArgs;
    }

    /**
     * @param \string[] $missingArgs
     */
    public function setMissingArgs( $missingArgs) {
        $this->missingArgs = $missingArgs;
        $this->message .= ' : ( '. implode( ', ', $missingArgs) .')';
    }

    /**
     * @return \string[]
     */
    public function getProvidedArgs() {
        return $this->providedArgs;
    }

    /**
     * @param \string[] $providedArgs
     */
    public function setProvidedArgs( $providedArgs) {
        $this->providedArgs = $providedArgs;
    }

    /**
     * @return \string[]
     */
    public function getRequiredArgs() {
        return $this->requiredArgs;
    }

    /**
     * @param \string[] $requiredArgs
     */
    public function setRequiredArgs( $requiredArgs) {
        $this->requiredArgs = $requiredArgs;
    }

}
