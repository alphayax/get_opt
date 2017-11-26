<?php

namespace alphayax\utils\cli\pattern;

/**
 * Trait SingletonTrait
 * @package alphayax\utils\cli\pattern
 */
trait SingletonTrait
{
    /** @var static */
    protected static $instance;

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

}
