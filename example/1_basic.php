#!/usr/bin/env php
<?php

use alphayax\utils\cli\GetOpt;

require_once '../vendor/autoload.php';

$Opt = GetOpt::getInstance();
$Opt->setDescription('This script is a tiny example to show library features');
$Opt->addLongOpt('file', 'Specify the file name', true);
$Opt->addLongOpt('dry-run', 'Dry Run mode');
$Opt->addShortOpt('n', 'Number of lines', true, true);
$Opt->addShortOpt('d', 'Debug mode');
$Opt->addOpt('v', 'verbose', 'Verbose Mode');

$Opt->parse();

print_r($Opt);
