<?php

namespace M2MAPP;

class SQLQueries
{
    public function __construct() { }

    public function __destruct() { }

    public function getMessages()
    {
        $query_string  = "SELECT id, source, destination, date, type, message ";
        $query_string .= "FROM messages ";
        $query_string .= "ORDER BY id;";
        return $query_string;
    }

    public function getSwitchStates()
    {
        $query_string  = "SELECT id, switch1, switch2, switch3, switch4, fan, heater, keypad ";
        $query_string .= "FROM switch ";
        $query_string .= "WHERE id=1;";
        return $query_string;
    }

    public function changeSwitchStates(){
        $query_string  = "INSERT INTO `switch` (`id`, `switch1`, `switch2`, `switch3`, `switch4`, `fan`, `heater`, `keypad`) VALUES
        (1,	:switch2,	:switch3,	:switch3,	:switch4,	:fan,	:heater,	:keypad);";
        return $query_string;
    }

    public function storeMessage()
    {
        $query_string  = 'INSERT INTO messages ( id, source, destination, date, type, message ) VALUES ( NULL, ":source", ":destination", ":date", ":type", ":message" );';
        return $query_string;
    }

    public function getTokens()
    {
        $query_string  = "";
        $query_string .= "";
        $query_string .= ";";
        return $query_string;
    }

    public function storeToken()
    {
        $query_string  = "INSERT INTO tokens ";
        $query_string .= "SET ";
        $query_string .= "id = :stock_date, ";
        $query_string .= "token = :stock_time;";
        return $query_string;
    }

}
