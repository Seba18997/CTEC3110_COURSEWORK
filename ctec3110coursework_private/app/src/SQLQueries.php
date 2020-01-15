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

    public function deleteMessages($range)
    {
        $query_string = "DELETE FROM messages ";
        $query_string .= "WHERE id ";
        $query_string .= "BETWEEN 1 AND $range;";
        return $query_string;
    }

    public function setAIFromOne()
    {
        $query_string = "ALTER TABLE messages AUTO_INCREMENT = 1;";
        return $query_string;
    }

    public function storeMessage()
    {
        $query_string  = 'INSERT INTO messages ( id, source, destination, date, type, message ) VALUES ( NULL, :source, :destination, :date, :type, :message );';
        return $query_string;
    }

    public function updateSwitchState()
    {
        $query_string = "UPDATE switch " ;
        $query_string .= "SET switch1 = ISNull(:switch1), " ;
        $query_string .= "switch2 = ISNull(:switch2), " ;
        $query_string .= "switch3 = ISNull(:switch3), " ;
        $query_string .= "switch4 = ISNull(:switch4), " ;
        $query_string .= "fan = ISNull(:fan), " ;
        $query_string .= "heater = ISNull(:heater), " ;
        $query_string .= "keypad = ISNull(:keypad) ";
        $query_string .= "WHERE id=1;";
        return $query_string;
    }
    
}



