#!/usr/bin/env php
<?php

require_once '../vendor/autoload.php';

$Opt = new \alphayax\utils\cli\GetOpt();
$Opt->setDescription('This script is a tiny example to show library features');
$fileOption = $Opt->addOpt('f', 'file', 'Specify the file name', true);

$Opt->parse();

// Check if file option is specified (via -f or --file)
if( ! $Opt->hasOption( $fileOption)){
    echo "File option has not been provided";
    return;
}


$fileName = $Opt->getValue( $fileOption);
echo "File option provided ! Value : $fileName";

