<?php

namespace M2MAPP;

class Helper
{
    public function __construct() { }

    public function __destruct() { }

    /**
     * @param $data
     * @return \SimpleXMLElement
     */
    public function convertSoapArrayToString($data){

        $final = simplexml_load_string($data);

        return $final;
    }

    /**
     * @param $givenstring
     * @param string $tag
     * @return \SimpleXMLElement
     */
    public function mapDataFromString($givenstring, $tag=''){

        $input = $this->convertSoapArrayToString($givenstring);

        $result = $input->$tag;

        return $result;

    }

    /**
     * @param $string
     * @param $start
     * @param $end
     * @return bool|string
     */

    public function getTheValue($string, $start, $end){

        $string = ' ' . $string;

        $ini = strpos($string, $start);

        if ($ini == 0) return '';

        $ini += strlen($start);

        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);

    }


    public function countRowsInArray($array=[]){
        @$count = count(array_filter($array, function($x) { return !empty($x); }));
        return $count;
    }

}