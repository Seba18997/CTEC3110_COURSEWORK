<?php

namespace M2MAPP;

class Helper
{
    public function __construct() { }

    public function __destruct() { }

    public function convertSoapArrayToString($data){

        $final = simplexml_load_string($data);

        return $final;
    }

    public function mapDataFromString($givenstring, $tag=''){

        $input = $this->convertSoapArrayToString($givenstring);

        $result = $input->$tag;

        return $result;

    }

}