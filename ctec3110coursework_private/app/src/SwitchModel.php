<?php


namespace M2MAPP;


class SwitchModel
{
    private $database_wrapper;
    private $database_connection_settings;
    private $sql_queries;

    public function __construct(){}

    public function __destruct(){}

    public function setDatabaseWrapper($database_wrapper)
    {
        $this->database_wrapper = $database_wrapper;
    }

    public function setDatabaseConnectionSettings($database_connection_settings)
    {
        $this->database_connection_settings = $database_connection_settings;
    }

    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    public function getSwitchState()
    {
        $switch_states = [];

        $query_string = $this->sql_queries->getSwitchStates();

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $this->database_wrapper->safeQuery($query_string);

        $number_of_data_sets = $this->database_wrapper->countRows();

        if ($number_of_data_sets === 1)
        {
            while ($row = $this->database_wrapper->safeFetchArray()) {
                $switch_states['switch1'] = $row['switch1'];
                $switch_states['switch2'] = $row['switch2'];
                $switch_states['switch3'] = $row['switch3'];
                $switch_states['switch4'] = $row['switch4'];
                $switch_states['fan'] = $row['fan'];
                $switch_states['heater'] = $row['heater'];
                $switch_states['keypad'] = $row['keypad'];
            }
        }
        else
        {
            $final_states[0] = 'Something is wrong';
        }

        $final_states['retrieved_switch_states'] = $switch_states;

        return $final_states;
    }

    public function updateSwitchStates($final_state=[]){

        $query_string = $this->sql_queries->updateSwitchState();

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $query_parameters =
            array(':switch1' => $final_state['switch1'],
                ':switch2' => $final_state['switch2'],
                ':switch3' => $final_state['switch3'],
                ':switch4' => $final_state['switch4'],
                ':fan'     => $final_state['fan'],
                ':heater'  => $final_state['heater'],
                ':keypad'  => $final_state['keypad']);

        if ($final_state['groupid'] == '19-3110-AZ' && !empty($final_state)){

            $this->database_wrapper->safeQuery($query_string, $query_parameters);

            $final = 'Switch states changed';
        }
        else if (empty($final_state))
        {
            $final =  'Array is empty.';
        }
        else {
            $final =  'Error with changing states.';
        }

        return $final;
    }

}