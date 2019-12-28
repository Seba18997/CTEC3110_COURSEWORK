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

    public function generateToken($length) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomToken = '';

        for ($i = 0; $i < $length; $i++) {
            $randomToken .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomToken;
    }

}