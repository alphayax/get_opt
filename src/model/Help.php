<?php
namespace alphayax\utils\cli\model;

class Help {

    /** @var string */
    protected $description;

    /**
     *
     */
    protected function displayDescription() {
        if( $this->description){
            echo "Description" . PHP_EOL;
            echo "\t". $this->description. PHP_EOL;
            echo PHP_EOL;
        }
    }

    /**
     *
     */
    protected function displayUsage() {
        echo 'Usage' . PHP_EOL;
        echo "\t/usr/bin/php " . basename( $_SERVER['SCRIPT_FILENAME']) . ' [OPTIONS]';
        echo PHP_EOL;
        echo PHP_EOL;
    }

    /**
     * @param \alphayax\utils\cli\model\OptionList $optionList
     */
    protected function displayOptions( OptionList $optionList) {
        echo 'Options' . PHP_EOL;
        $options  = $optionList->getAll();
        $longPad  = $optionList->getLongPad();
        $shortPad = $optionList->getShortPad();
        $emptyShortPad = str_repeat( ' ', $shortPad);
        $emptyLongPad  = str_repeat( ' ', $longPad);
        foreach( $options as $option){

            $C = $option->hasValue() ? ' <value>' : '';

            /// Short opt
            $C1 = $emptyShortPad;
            if( $option->hasShortOpt()){
                $C1 = '-'. $option->getShortOpt();
                if( $option->hasValue()){
                    $C1 .= ' <value>';
                }
                $C1 = str_pad( $C1, $shortPad, ' ');
            }

            /// Long opt
            $C2 = $emptyLongPad;
            if( $option->hasLongOpt()){
                $C2 = '--'. $option->getLongOpt();
                if( $option->hasValue()){
                    $C2 .= ' <value>';
                }
                $C2 = str_pad( $C2, $longPad, ' ');
            }

            $C3 = $option->getDescription();
            if( $option->isRequired()){
                $C3 = '[REQUIRED] '. $C3;
            }

            
            echo "\t$C1\t$C2\t$C3".PHP_EOL;
        }

        echo PHP_EOL;
    }

    /**
     * Display help & quit
     * @param \alphayax\utils\cli\model\OptionList $optionList
     */
    public function display( OptionList $optionList) {
        $this->displayDescription();
        $this->displayUsage();
        $this->displayOptions( $optionList);
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

}
