<?php

class HelpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $optionList
     * @dataProvider optionListProvider
     */
    public function testConstruct($optionList)
    {
        $help = new \alphayax\utils\cli\model\Help();
        $help->setDescription("Description");
        $help->display($optionList);
    }

    /**
     * @return array
     * @throws \alphayax\utils\cli\exception\ConflictException
     */
    public function optionListProvider()
    {
        $optionList = new \alphayax\utils\cli\model\OptionList();
        $optionList->add(new \alphayax\utils\cli\model\Option('a', 'aa', 'AAA'));

        return [[$optionList]];
    }
}
