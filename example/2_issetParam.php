#!/usr/bin/env php
<?php

use alphayax\utils\cli\GetOpt;

require_once '../vendor/autoload.php';

$Opt = GetOpt::getInstance();
$Opt->setDescription('This script is a tiny example to show library features');

$verboseOption = $Opt->addOpt('v', 'verbose', 'Verbose Mode');

$Opt->parse();

// Check if option verbose is specified
if( $verboseOption->isPresent()){
    echo 'Option verbose is enabled'. PHP_EOL;
} else {
    echo 'Verbose mode disabled'. PHP_EOL;
}
