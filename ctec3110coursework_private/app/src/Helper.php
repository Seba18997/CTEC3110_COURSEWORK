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
        $count = count(array_filter($array, function($x) { return !empty($x); }));
        return $count;
    }

    public function decodeMessage($message_content=''){

        //SMS message format: "switch1:on;switch2:on;switch3:off;switch4:on;fan:forward;heater:3;keypad:4;id:19-3110-AZ"

        $final_message['switch1'] = (new Helper)->getTheValue($message_content, 'switch1:', ';');
        $final_message['switch2'] = (new Helper)->getTheValue($message_content, 'switch2:', ';');
        $final_message['switch3'] = (new Helper)->getTheValue($message_content, 'switch3:', ';');
        $final_message['switch4'] = (new Helper)->getTheValue($message_content, 'switch4:', ';');
        $final_message['fan']     = (new Helper)->getTheValue($message_content, 'fan:',     ';');
        $final_message['heater']  = (new Helper)->getTheValue($message_content, 'heater:',  ';');
        $final_message['keypad']  = (new Helper)->getTheValue($message_content, 'keypad:',  ';');
        $final_message['groupid'] = (new Helper)->getTheValue($message_content, 'id:',      ';');

        return $final_message;

    }

}