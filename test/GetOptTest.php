<?php
use alphayax\utils\cli\GetOpt;

/**
 * Class GetOptTest
 */
class GetOptTest extends PHPUnit_Framework_TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testConstruct()
    {
        $opt = GetOpt::getInstance();
        $opt->setDescription('This script is a tiny example to show library features');
        $opt->addLongOpt('dry-run', 'Dry Run mode');
        $opt->addShortOpt('d', 'Debug mode');
        $opt->addOpt('v', 'verbose', "Verbose Mode");

        $opt->parse();
    }

    /**
     * @throws \alphayax\utils\cli\exception\ConflictException
     * @expectedException \alphayax\utils\cli\exception\ConflictException
     * @runInSeparateProcess
     */
    public function testDuplicate()
    {
        $opt = GetOpt::getInstance();
        $opt->addShortOpt('d', 'Debug mode');
        $opt->addShortOpt('d', 'Debug mode');

        $opt->parse();
    }

}
