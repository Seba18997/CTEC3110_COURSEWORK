<?php

namespace M2MAPP;

class Decoder
{

    public function __construct() { }

    public function __destruct() { }

    public function makeConnection()
    {
        $connection = (new DatabaseWrapper)->makeDatabaseConnection();
        return $connection;
    }

    public function doMakeQuery($query, $params='')
    {
        $make_query = (new DatabaseWrapper)->safeQuery($query, $params);
        return $make_query;
    }

    /**
     * @param $message_content
     * @return mixed
     */

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

    /**
     * @param array $final_state
     * @return mixed
     */

    public function updateSwitchStates($final_state=[]){

        $this->makeConnection();
        $query = (new SQLQueries)->updateSwitchState();

        $final_state = [];

        $final_state['switch1'] = $switch1db;
        $final_state['switch2'] = $switch2db;
        $final_state['switch3'] = $switch3db;
        $final_state['switch4'] = $switch4db;
        $final_state['fan'] = $fandb;
        $final_state['heater'] = $heaterdb;
        $final_state['keypad'] = $keypaddb;

        $query_parameters =
            array(':switch1' => $switch1db, ':switch2' => $switch2db, ':switch3' => $switch3db, ':switch4' => $switch4db, ':fan' => $fandb, ':heater' => $heaterdb, ':keypad' => $keypaddb);

        return $this->doMakeQuery($query, $query_parameters);

    }


}