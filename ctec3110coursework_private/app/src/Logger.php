<?php


namespace M2MAPP;


class Logger
{
    private $logfileurl;

    public function __construct() {
         $this->logfileurl = NULL;
    }

    public function __destruct() {

    }
    public function setLogFile($logfile)
    {
        $this->logfileurl = $logfile;
    }

    public function readLogFile(){
        $logfile = fopen($this->logfileurl, 'r') or die ('File opening failed');
        $data = [];
        $x = 0;
        $line = 0;
        $final_info = [];
        $helper = new Helper();

        while (!feof($logfile)) {
            $oneline = fgets($logfile);
            $data['date'][$x] = $helper->getTheValue($oneline, '[', 'T');
            $data['hour'][$x] = substr($helper->getTheValue($oneline, 'T', '+'), 0, 8);
            $data['type'][$x] = $helper->getTheValue($oneline, 'M2MAPP_Logger.', ':');
            $data['action'][$x] = $helper->getTheValue($oneline, ': ', ' [] []');
            $line++;
            $x++;
        }

        $final_info['log_file'] = $data;
        $final_info['log_counter'] = $line;

        fclose($logfile);

        return $final_info;
    }


}