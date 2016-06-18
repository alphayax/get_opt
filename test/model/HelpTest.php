<?php

class HelpTest extends \PHPUnit_Framework_TestCase {


    public function testConstruct() {

        $optionList = new \alphayax\utils\cli\model\OptionList();

        $help = new \alphayax\utils\cli\model\Help();
        $help->setDescription( "Description");
        $help->display( $optionList);
    }
}
