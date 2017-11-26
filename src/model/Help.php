<?php

namespace alphayax\utils\cli\model;

/**
 * Class Help
 * @package alphayax\utils\cli\model
 */
class Help
{
    /** @var string */
    protected $description = '';

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Display the description
     */
    protected function displayDescription()
    {
        if ( ! empty($this->description)) {
            echo 'Description' . PHP_EOL;
            echo "\t" . $this->description . PHP_EOL;
            echo PHP_EOL;
        }
    }

    /**
     * Display the "how to use" line
     */
    protected function displayUsage()
    {
        echo 'Usage' . PHP_EOL;
        echo "\t/usr/bin/php " . basename($_SERVER['SCRIPT_FILENAME']) . ' [OPTIONS]' . PHP_EOL;
        echo PHP_EOL;
    }

    /**
     * Display all the available options
     * @param \alphayax\utils\cli\model\OptionList $optionList
     */
    protected function displayOptions(OptionList $optionList)
    {
        echo 'Options' . PHP_EOL;
        $options = $optionList->getAll();
        $longPad = $optionList->getLongPad();
        $shortPad = $optionList->getShortPad();
        $emptyShortPad = str_repeat(' ', $shortPad);
        $emptyLongPad = str_repeat(' ', $longPad);
        foreach ($options as $option) {

            $valueFlag = $option->askValue() ? ' <value>' : '';

            /// Short opt
            $shortOpt = $emptyShortPad;
            if ($option->hasShortOpt()) {
                $shortOpt = '-' . $option->getShortOpt() . $valueFlag;
                $shortOpt = str_pad($shortOpt, $shortPad, ' ');
            }

            /// Long opt
            $longOpt = $emptyLongPad;
            if ($option->hasLongOpt()) {
                $longOpt = '--' . $option->getLongOpt() . $valueFlag;
                $longOpt = str_pad($longOpt, $longPad, ' ');
            }

            $description = $option->getDescription();
            if ($option->isRequired()) {
                $description = '[REQUIRED] ' . $description;
            }

            echo "\t$shortOpt\t$longOpt\t$description" . PHP_EOL;
        }

        echo PHP_EOL;
    }

    /**
     * Display help & quit
     * @param \alphayax\utils\cli\model\OptionList $optionList
     */
    public function display(OptionList $optionList)
    {
        $this->displayDescription();
        $this->displayUsage();
        $this->displayOptions($optionList);
    }

}
