<?php
/*
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require 'vendor/autoload.php';
$logs_file_path = '/p3t/phpappfolder/logs/';
$logs_file_name = 'tester15.log';
$logs_file = $logs_file_path . $logs_file_name;
// create a log channel
$log = new Logger('logger');
$log->pushHandler(new StreamHandler($logs_file,
    Logger::WARNING));
// add records to the log
echo 'Adding entries to the log file';
$log->warning('Testing the Monolog library');
$log->error('Bar');
*/