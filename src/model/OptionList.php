<?php
namespace alphayax\utils\cli\model;

/**
 * Class OptionList
 * @package alphayax\utils\cli\model
 */
class OptionList implements \Iterator {

    /** @var Option[] */
    protected $options;

    /** @var int */
    protected $iteratorIndex = 0;

    /**
     * @param \alphayax\utils\cli\model\Option $option
     */
    public function add( Option $option) {
        $this->options[] = $option;
    }

    public function serializeLongOpts() {
        $longOpts = [];
        foreach( $this->options as $option){
            if( $option->hasLongOpt()){
                $hasValueFlag = $option->hasValue() ? ':' : '';
                $longOpts[] = $option->getLongOpt() . $hasValueFlag;
            }
        }
        return $longOpts;
    }

    public function serializeShortOpts() {
        $letters = '';
        foreach( $this->options as $option){
            if( $option->hasShortOpt()){
                $hasValueFlag = $option->hasValue() ? ':' : '';
                $letters .= $option->getShortOpt() . $hasValueFlag;
            }
        }
        return $letters;
    }

    public function getAll() {
        $options = $this->options;
        usort( $options, function( Option $a, Option $b){
            $a = $a->hasShortOpt() ? $a->getShortOpt() : $a->getLongOpt();
            $b = $b->hasShortOpt() ? $b->getShortOpt() : $b->getLongOpt();
            return $a < $b ? -1 : 1;
        });
        return $options;
    }

    public function getRequiredOpts() {
        $requiredOpts = [];
        foreach( $this->options as $option){
            if( $option->isRequired()){
                $requiredOpts[] = $option->hasShortOpt() ? $option->getShortOpt() : $option->getLongOpt();
            }
        }
        return $requiredOpts;
    }

    public function getLongPad() {
        $pad = 1;
        foreach( $this->options as $option){
            if( $option->hasLongOpt()){
                $optLen = strlen( $option->getLongOpt());
                if( $option->hasValue()){
                    $optLen += 8;   // +8 is for the str len of " <value>"
                }
                $pad = $optLen > $pad ? $optLen : $pad;
            }
        }
        return $pad + 2; // +2 is for double hyphen (--)
    }

    public function getShortPad() {
        $pad = 1;
        foreach( $this->options as $option){
            if( $option->hasShortOpt()){
                $optLen = strlen( $option->getShortOpt());
                if( $option->hasValue()){
                    $optLen += 8;   // +8 is for the str len of " <value>"
                }
                $pad = $optLen > $pad ? $optLen : $pad;
            }
        }
        return $pad + 1; // +1 is for simple hyphen (-)
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current() {
        return $this->options[$this->iteratorIndex];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next() {
        $this->iteratorIndex++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key() {
        return $this->iteratorIndex;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid() {
        return array_key_exists( $this->iteratorIndex, $this->options);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind() {
        $this->iteratorIndex = 0;
    }

}
