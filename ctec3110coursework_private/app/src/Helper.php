<?php

namespace M2MAPP;

use http\Params;

class Helper
{
    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    /**
     * @param $data
     * @return \SimpleXMLElement
     */
    public function convertSoapArrayToString($data)
    {
        $final = simplexml_load_string($data);
        return $final;
    }

    /**
     * @param $givenstring
     * @param string $tag
     * @return \SimpleXMLElement
     */
    public function mapDataFromString($givenstring, $tag='')
    {
        $input = $this->convertSoapArrayToString($givenstring);
        $result = $input->$tag;
        return $result;
    }

    /**
     * @param $string
     * @param $start
     * @param $end
     * @return false|string
     */
    public function getTheValue($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     * @param array $array
     * @return int
     */
    public function countRowsInArray($array=[])
    {
        $count = count(array_filter($array, function($x) { return !empty($x); }));
        return $count;
    }

    /**
     * @param string $message_content
     * @return mixed
     */
    public function decodeMessage($message_content='')
    {
        $final_message['switch1'] = $this->getTheValue($message_content, 'switch1:', ';');
        $final_message['switch2'] = $this->getTheValue($message_content, 'switch2:', ';');
        $final_message['switch3'] = $this->getTheValue($message_content, 'switch3:', ';');
        $final_message['switch4'] = $this->getTheValue($message_content, 'switch4:', ';');
        $final_message['fan']     = $this->getTheValue($message_content, 'fan:',     ';');
        $final_message['heater']  = $this->getTheValue($message_content, 'heater:',  ';');
        $final_message['keypad']  = $this->getTheValue($message_content, 'keypad:',  ';');
        $final_message['groupid'] = $this->getTheValue($message_content, 'id:',      ';');
        return $final_message;
    }

    public function matchString($string1, $string2){
        if ($string1 == $string2){
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

 }