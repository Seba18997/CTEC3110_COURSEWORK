<?php


namespace M2MAPP;


class Logger
{
    private $logfileurl;

    public function __construct()
    {
         $this->logfileurl = NULL;
    }

    public function __destruct()
    {

    }

    /**
     * @param $logfile
     */
    public function setLogFile($logfile)
    {
        $this->logfileurl = $logfile;
    }

    /**
     * @return array
     */
    public function readLogFile()
    {
        $logfile = fopen($this->logfileurl, 'r') or die ('File opening failed');
        $data = [];
        $x = 0;
        $line = 0;
        $final_info = [];
        $helper = new Helper();

        while (!feof($logfile)) {
            $oneline = fgets($logfile);
            $data[$x]['date'] = $helper->getTheValue($oneline, '[', 'T');
            $data[$x]['hour'] = substr($helper->getTheValue($oneline, 'T', '+'), 0, 8);
            $data[$x]['type'] = $helper->getTheValue($oneline, 'M2MAPP_Logger.', ':');
            $data[$x]['action'] = $helper->getTheValue($oneline, ': ', ' [] []');
            $data[$x]['id'] = $x + 1;
            $line++;
            $x++;
        }

        $final_info['log_file'] = $data;
        $final_info['log_counter'] = $line - 1;

        fclose($logfile);

        return $final_info;
    }


}