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

    public function decodeMessage($message_content=''){

        //SMS message format: "switch1:on;switch2:on;switch3:off;switch4:on;fan:forward;heater:3;keypad:4;id:19-3110-AZ"

        $final_message['switch1'] = (new Helper)->getTheValue($message_content, 'switch1:', ';');
        $final_message['switch2'] = (new Helper)->getTheValue($message_content, 'switch2:', ';');
        $final_message['switch3'] = (new Helper)->getTheValue($message_content, 'switch3:', ';');
        $final_message['switch4'] = (new Helper)->getTheValue($message_content, 'switch4:', ';');
        $final_message['fan']     = (new Helper)->getTheValue($message_content, 'fan:',     ';');
        $final_message['heater']  = (new Helper)->getTheValue($message_content, 'heater:',  ';');
        $final_message['keypad']  = (new Helper)->getTheValue($message_content, 'keypad:',  ';');
        $final_message['groupid'] = (new Helper)->getTheValue($message_content, 'id:',      'Z');

        return $final_message;

    }

    /**
     * @param array $final_state
     * @return mixed
     */

    public function updateSwitchStates($final_state=[]){

        $this->makeConnection();
        $query = (new SQLQueries)->updateSwitchState();

        $query_parameters =
            array(':switch1' => $final_state['switch1'],
                ':switch2' => $final_state['switch2'],
                ':switch3' => $final_state['switch3'],
                ':switch4' => $final_state['switch4'],
                ':fan' => $final_state['fan'],
                ':heater' => $final_state['heater'],
                ':keypad' => $final_state['keypad']);

        return $this->doMakeQuery($query, $query_parameters);

    }


}