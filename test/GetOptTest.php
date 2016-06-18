<?php

/**
 * Class GetOptTest
 */
class GetOptTest extends PHPUnit_Framework_TestCase {

    public function testConstruct() {
        $a = new \alphayax\utils\cli\GetOpt();
        $a->setDescription( 'This script is a tiny example to show library features');
        $a->addLongOpt( 'dry-run', 'Dry Run mode');
        $a->addShortOpt( 'd', 'Debug mode');
        $a->addOpt( 'v', 'verbose', "Verbose Mode");
        $a->parse();
    }

}
