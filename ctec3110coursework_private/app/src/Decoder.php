<?php

namespace M2MAPP;

class Decoder
{

    public function __construct() { }

    public function __destruct() { }

    public function decodeMessage($message_content){

        $str = $message_content;

        //SMS message format: "switch1:on;switch2:on;switch3:off;switch4:on;fan:forward;heater:3;keypad:4;id:19-3110-AZ"

        $switch1     = get_string_between($str, 'switch1:', ';switch2');
        $switch2     = get_string_between($str, 'switch2:', ';switch3');
        $switch3     = get_string_between($str, 'switch3:', ';switch4');
        $switch4     = get_string_between($str, 'switch4:', ';fan');
        $fan         = get_string_between($str, 'fan:',     ';heater');
        $heater      = get_string_between($str, 'heater:',  ';keypad');
        $keypad      = get_string_between($str, 'keypad:',  ';id');
   //     $group_id    = get_string_between($str, 'id:',      'Z');

        $final_message['switch1'] = $switch1;
        $final_message['switch2'] = $switch2;
        $final_message['switch3'] = $switch3;
        $final_message['switch4'] = $switch4;
        $final_message['fan'] = $fan;
        $final_message['heater'] = $heater;
        $final_message['keypad'] = $keypad;
   //     $final_message['group_id'] = $group_id;

        return $final_message;

    }




}