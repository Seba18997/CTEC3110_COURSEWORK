<?php

namespace M2MAPP{

    class MessagesModel
    {
        public function __construct(){
        }

        public function __destruct(){
        }

        public function decodeMessage($message_content){

            $str = $message_content;

            //SMS message format: "switch1:onswitch2:onswitch3:offswitch4:onfan:forward
            // heater:3keypad:4id:19-3110-AZ"

            $switch1     = $this->get_string_between($str, 'switch1:', 'switch2');
            $switch2     = $this->get_string_between($str, 'switch2:', 'switch3');
            $switch3     = $this->get_string_between($str, 'switch3:', 'switch4');
            $switch4     = $this->get_string_between($str, 'switch4:', 'fan');
            $fan         = $this->get_string_between($str, 'fan:',     'heater');
            $heater      = $this->get_string_between($str, 'heater:',  'keypad');
            $keypad      = $this->get_string_between($str, 'keypad:',  'id');
            $group_id    = $this->get_string_between($str, 'id:',      'Z');


            $final_message = "Switch1: $switch1 Switch2: $switch2 Switch3: $switch3 Switch4: $switch4 Fan: $fan Heater: $heater Keypad: $keypad ID: $group_id";

             return $final_message;

         }

        public function get_string_between($string, $start, $end){
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
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


}}