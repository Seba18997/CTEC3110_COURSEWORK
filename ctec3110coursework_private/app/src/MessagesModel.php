<?php

namespace M2MAPP;

class MessagesModel
{
    private $result;

    public function __construct(){
    }

    public function __destruct(){
    }

    public function getMessageData($soap_call_result){

        try {

        $filteredArray = (array_filter($soap_call_result, function($k) {
            return $k == 37;
        }, ARRAY_FILTER_USE_KEY));

        //echo json_encode($filteredArray);
        $str = json_encode($filteredArray);

        //SMS message format: "switch1:onswitch2:onswitch3:offswitch4:onfan:forward
        // heater:3keypad:4id:19-3110-AZ"

        $switch1     = get_string_between($str, 'switch1:', 'switch2');
        $switch2     = get_string_between($str, 'switch2:', 'switch3');
        $switch3     = get_string_between($str, 'switch3:', 'switch4');
        $switch4     = get_string_between($str, 'switch4:', 'fan');
        $fan         = get_string_between($str, 'fan:',     'heater');
        $heater      = get_string_between($str, 'heater:',  'keypad');
        $keypad      = get_string_between($str, 'keypad:',  'id');
        $group_id     = get_string_between($str, 'id:',      'Z');


        $final_message = "Switch1: $switch1 Switch2: $switch2 Switch3: $switch3 Switch4: $switch4 Fan: $fan Heater: $heater Keypad: $keypad ID: $group_id";

            }
            catch (\SoapFault $exception)
            {
                $final_message = 'Oops - something went wrong connecting to the data supplier.  Please try again later';
            }

        return $final_message;
    }

    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }


/*
    public function generateToken($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomToken = '';
        for ($i = 0; $i < $length; $i++) {
            $randomToken .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomToken;
    } */


}