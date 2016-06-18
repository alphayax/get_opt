
# Get Opt

A library to manage scripts arguments 


[![Latest Stable Version](https://poser.pugx.org/alphayax/get_opt/v/stable)](https://packagist.org/packages/alphayax/get_opt)
[![Latest Unstable Version](https://poser.pugx.org/alphayax/get_opt/v/unstable)](https://packagist.org/packages/alphayax/get_opt)
[![pakagist](https://img.shields.io/packagist/v/alphayax/get_opt.svg)](https://packagist.org/packages/alphayax/get_opt)

[![Travis](https://travis-ci.org/alphayax/get_opt.svg)](https://travis-ci.org/alphayax/get_opt)
[![Coverage Status](https://api.codacy.com/project/badge/Coverage/7bcc28be8edf41d8b9285418197d093f)](https://www.codacy.com/app/alphayax/get_opt?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=alphayax/get_opt&amp;utm_campaign=Badge_Coverage)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/7bcc28be8edf41d8b9285418197d093f)](https://www.codacy.com/app/alphayax/get_opt?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=alphayax/get_opt&amp;utm_campaign=Badge_Grade)

[![License](https://poser.pugx.org/alphayax/get_opt/license)](https://packagist.org/packages/alphayax/get_opt)
[![Total Downloads](https://poser.pugx.org/alphayax/get_opt/downloads)](https://packagist.org/packages/alphayax/get_opt)

### GetOpt

A class to parse parameters given to a script

```php
$Args = new GetOpt();
$Args->addShortOpt( 'd', 'Debug mode');
$Args->addLongOpt( 'dry-run', 'Dry Run mode');
$Args->addOpt( 'v', 'verbose', 'Verbose Mode');
$Args->parse();

$isDryRun  = $Args->hasOption( 'dry-run');
$isVerbose = $Args->hasOption( 'v') || $Args->hasOption( 'verbose');
```

### Auto-generated Help

Example of help output (if the -h or --help flag is specified) :

```
    Description
   	This script is a tiny example to show library features
   
   Usage
   	/usr/bin/php a.php [OPTIONS]
   
   Options
	-d        	              	Debug mode
	          	--dry-run     	Dry Run mode
	          	--file <value>	Specify the file name
	-h        	--help        	Display help
	-n <value>	              	[REQUIRED] Number of lines
	-v        	--verbose     	Verbose Mode
```
