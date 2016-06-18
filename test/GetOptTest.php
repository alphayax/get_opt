<?php

/**
 * Class GetOptTest
 */
class GetOptTest extends PHPUnit_Framework_TestCase {

    public function testConstruct() {
        $opt = new \alphayax\utils\cli\GetOpt();
        $opt->setDescription( 'This script is a tiny example to show library features');
        $opt->addLongOpt( 'dry-run', 'Dry Run mode');
        $opt->addShortOpt( 'd', 'Debug mode');
        $opt->addOpt( 'v', 'verbose', "Verbose Mode");
        $opt->parse();
    }

    /**
     * @throws \alphayax\utils\cli\exception\MissingArgException
     */
    public function testException() {

        $this->setExpectedException( \alphayax\utils\cli\exception\MissingArgException::class);

        $opt = new \alphayax\utils\cli\GetOpt();
        $opt->setDescription( 'This script is a tiny example to show library features');
        $opt->addLongOpt( 'dry-run', 'Dry Run mode', true, true);
        $opt->addShortOpt( 'd', 'Debug mode');
        $opt->addOpt( 'v', 'verbose', "Verbose Mode");
        $opt->parse();
    }


}
