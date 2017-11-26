<?php

namespace alphayax\utils\cli\model;

use alphayax\utils\cli\exception\ConflictException;
use alphayax\utils\cli\exception\MissingArgException;
use alphayax\utils\cli\exception\UndefinedOptionException;

/**
 * Class OptionList
 * @package alphayax\utils\cli\model
 */
class OptionList implements \Iterator
{
    /** @var Option[] */
    protected $options = [];

    /** @var Option[] */
    protected $options_by_letter = [];

    /** @var Option[] */
    protected $options_by_name = [];

    /** @var int */
    protected $iteratorIndex = 0;

    /** @var array string */
    protected $provided_opts;

    /**
     * Add an option to the list
     * @param \alphayax\utils\cli\model\Option $option
     * @throws \alphayax\utils\cli\exception\ConflictException
     */
    public function add(Option $option)
    {
        $this->options[] = $option;

        if ($option->hasShortOpt()) {
            if ($this->hasShortOptName($option->getShortOpt())) {
                throw new ConflictException('Short option -' . $option->getShortOpt() . ' is already defined');
            }
            $this->options_by_letter[$option->getShortOpt()] = $option;
        }

        if ($option->hasLongOpt()) {
            if ($this->hasLongOptName($option->getLongOpt())) {
                throw new ConflictException('Long option --' . $option->getLongOpt() . ' is already defined');
            }
            $this->options_by_name[$option->getLongOpt()] = $option;
        }
    }

    /**
     *
     */
    public function parse()
    {
        $this->provided_opts = getopt($this->serializeShortOpts(), $this->serializeLongOpts());

        try {

            foreach ($this->provided_opts as $key => $value) {

                $option = $this->getFromOptName($key);
                $option->setIsPresent(true);
                $option->setValue($value);

                continue;
            }
        } catch (UndefinedOptionException $e) {
            trigger_error( $e->getMessage());
        }
    }

    /**
     * Return an array with longs option for get_opt
     * @return array
     */
    public function serializeLongOpts()
    {
        $longOpts = [];
        foreach ($this->options_by_name as $option) {
            $hasValueFlag = $option->askValue() ? ':' : '';
            $longOpts[] = $option->getLongOpt() . $hasValueFlag;
        }
        return $longOpts;
    }

    /**
     * Return a serialized string with short options for get_opt
     * @return string
     */
    public function serializeShortOpts()
    {
        $letters = '';
        foreach ($this->options_by_letter as $option) {
            $hasValueFlag = $option->askValue() ? ':' : '';
            $letters .= $option->getShortOpt() . $hasValueFlag;
        }
        return $letters;
    }

    /**
     * Get all options
     * @return \alphayax\utils\cli\model\Option[]
     */
    public function getAll()
    {
        $options = $this->options;
        usort($options, function (Option $optionA, Option $optionB) {
            $optionA = $optionA->hasShortOpt() ? $optionA->getShortOpt() : $optionA->getLongOpt();
            $optionB = $optionB->hasShortOpt() ? $optionB->getShortOpt() : $optionB->getLongOpt();
            return $optionA < $optionB ? -1 : 1;
        });
        return $options;
    }

    /**
     * @param string $shortOptName
     * @return \alphayax\utils\cli\model\Option
     * @throws \alphayax\utils\cli\exception\UndefinedOptionException
     */
    public function getFromShortOptName($shortOptName)
    {
        if ($this->hasShortOptName($shortOptName)) {
            throw new UndefinedOptionException('Option -' . $shortOptName . ' is not defined');
        }

        return $this->options_by_letter[$shortOptName];
    }

    /**
     * @param string $shortOptName
     * @return boolean
     */
    public function hasShortOptName($shortOptName)
    {
        return array_key_exists($shortOptName, $this->options_by_letter);
    }

    /**
     * @param string $longOptName
     * @return \alphayax\utils\cli\model\Option
     * @throws \alphayax\utils\cli\exception\UndefinedOptionException
     */
    public function getFromLongOptName($longOptName)
    {
        if ( ! $this->hasLongOptName($longOptName)) {
            throw new UndefinedOptionException('Option --' . $longOptName . ' is undefined');
        }

        return $this->options_by_name[$longOptName];
    }

    /**
     * @param string $longOptName
     * @return boolean
     */
    public function hasLongOptName($longOptName)
    {
        return array_key_exists($longOptName, $this->options_by_name);
    }

    /**
     * @param $optName
     * @return \alphayax\utils\cli\model\Option
     * @throws \alphayax\utils\cli\exception\UndefinedOptionException
     */
    public function getFromOptName($optName)
    {
        if ($this->hasShortOptName($optName)) {
            return $this->options_by_letter[$optName];
        }

        if ($this->hasLongOptName($optName)) {
            return $this->options_by_name[$optName];
        }

        throw new UndefinedOptionException('Option ' . $optName . ' is undefined');
    }

    /**
     * Return true if the provided option name is in the available options (short or long)
     * @param $optName
     * @return bool
     */
    public function hasOptName($optName)
    {
        return $this->hasShortOptName($optName) || $this->hasLongOptName($optName);
    }

    /**
     * Get required options
     * @return Option[]
     */
    public function getRequiredOpts()
    {
        $requiredOpts = [];
        foreach ($this->options as $option) {
            if ($option->isRequired()) {
                $requiredOpts[] = $option;
            }
        }
        return $requiredOpts;
    }

    /**
     * @throws \alphayax\utils\cli\exception\MissingArgException
     */
    public function checkRequiredOptions()
    {
        $providedOpts = array_keys($this->provided_opts);
        $requiredOpts = $this->getRequiredOpts();

        $missingOpts = [];
        foreach ($requiredOpts as $requiredOpt) {
            if ( ! $requiredOpt->isPresent()) {
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
     * Get the pad of long args for display in help
     * @return int
     */
    public function getLongPad()
    {
        $pad = 1;
        foreach ($this->options_by_name as $option) {
            $optLen = strlen($option->getLongOpt());
            if ($option->askValue()) {
                $optLen += 8;   // +8 is for the str len of " <value>"
            }
            $pad = $optLen > $pad ? $optLen : $pad;
        }
        return $pad + 2; // +2 is for double hyphen (--)
    }

    /**
     * Get the pad of short args for display in help
     * @return int
     */
    public function getShortPad()
    {
        $pad = 1;
        foreach ($this->options_by_letter as $option) {
            $optLen = strlen($option->getShortOpt());
            if ($option->askValue()) {
                $optLen += 8;   // +8 is for the str len of " <value>"
            }
            $pad = $optLen > $pad ? $optLen : $pad;
        }
        return $pad + 1; // +1 is for simple hyphen (-)
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->options[$this->iteratorIndex];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->iteratorIndex++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->iteratorIndex;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return array_key_exists($this->iteratorIndex, $this->options);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->iteratorIndex = 0;
    }

}
