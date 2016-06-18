<?php

class HelpTest extends \PHPUnit_Framework_TestCase {


    public function testConstruct() {

        $optionList = new \alphayax\utils\cli\model\OptionList();
        $optionList->add( new \alphayax\utils\cli\model\Option( 'a', 'aa', 'AAA'));

        $help = new \alphayax\utils\cli\model\Help();
        $help->setDescription( "Description");
        $help->display( $optionList);
    }
}
