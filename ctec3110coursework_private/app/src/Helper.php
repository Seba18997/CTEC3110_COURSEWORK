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
     * @param $length
     * @return string
     */
    public function generateToken($length) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomToken = '';

        for ($i = 0; $i < $length; $i++) {
            $randomToken .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomToken;
    }

    /**
     * @param $string
     * @param $start
     * @param $end
     * @return bool|string
     */

    public function get_string_between($string, $start, $end){

        $string = ' ' . $string;

        $ini = strpos($string, $start);

        if ($ini == 0) return '';

        $ini += strlen($start);

        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);

    }

    /**
     * @param $array
     * @return int|null|string
     */
    public function getSizeofArray($array){

        $array = [];

        $end_of_array = end($array);

        $last_key = key($end_of_array);

        return $last_key;

    }

}