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
        $query_string .= "SET switch1 = CASE WHEN :switch1 IS NOT NULL AND LENGTH(:switch1) > 0 THEN :switch1 ELSE switch1 END, " ;
        $query_string .= "switch2 = CASE WHEN :switch2 IS NOT NULL AND LENGTH(:switch2) > 0 THEN :switch2 ELSE switch2 END, " ;
        $query_string .= "switch3 = CASE WHEN :switch3 IS NOT NULL AND LENGTH(:switch3) > 0 THEN :switch3 ELSE switch3 END, " ;
        $query_string .= "switch4 = CASE WHEN :switch4 IS NOT NULL AND LENGTH(:switch4) > 0 THEN :switch4 ELSE switch4 END, " ;
        $query_string .= "fan = CASE WHEN :fan IS NOT NULL AND LENGTH(:fan) > 0 THEN :fan ELSE fan END, " ;
        $query_string .= "heater = CASE WHEN :heater IS NOT NULL AND LENGTH(:heater) > 0 THEN :heater ELSE heater END, " ;
        $query_string .= "keypad = CASE WHEN :keypad IS NOT NULL AND LENGTH(:keypad) > 0 THEN :keypad ELSE keypad END ";
        $query_string .= "WHERE id=1;";
        return $query_string;
    }
    
}



