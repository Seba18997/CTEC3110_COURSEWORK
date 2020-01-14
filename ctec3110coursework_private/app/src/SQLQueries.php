<?php

namespace M2MAPP;

class SQLQueries
{
    public function __construct() { }

    public function __destruct() { }

    public function getUsernamePassword($username)
    {
        $query_string  = "SELECT user_name, password ";
        $query_string .= "FROM user_data ";
        $query_string .= "WHERE user_name='$username';";
        return $query_string;
    }

    public function getMessages()
    {
        $query_string  = "SELECT id, source, destination, date, type, message ";
        $query_string .= "FROM messages ";
        $query_string .= "WHERE date != '' ";
        $query_string .= "ORDER BY id DESC;";
        return $query_string;
    }

    public function getNewestMessage()
    {
        $query_string  = "SELECT message ";
        $query_string .= "FROM messages ";
        $query_string .= "WHERE date != '' ";
        $query_string .= "ORDER BY id DESC ";
        $query_string .= "LIMIT 1;";
        return $query_string;
    }

    public function getSwitchStates()
    {
        $query_string = "SELECT id, switch1, switch2, switch3, switch4, fan, heater, keypad ";
        $query_string .= "FROM switch ";
        $query_string .= "WHERE id=1;";
        return $query_string;
    }

    public function storeMessage()
    {
        $query_string  = 'INSERT INTO messages ( id, source, destination, date, type, message ) VALUES ( NULL, :source, :destination, :date, :type, :message );';
        return $query_string;
    }

    public function updateSwitchState()
    {
        $query_string = 'UPDATE switch 
                         SET switch1 = IfNull(:switch1, switch1), 
                         switch2 = IfNull(:switch2, switch2), 
                         switch3 = IfNull(:switch3, switch3), 
                         switch4 = IfNull(:switch4, switch4), 
                         fan = IfNull(:fan, fan), 
                         heater = IfNull(:heater, heater), 
                         keypad = IfNull(:keypad, keypad) ';
        $query_string .= "WHERE id=1;";
        return $query_string;
    }
}



