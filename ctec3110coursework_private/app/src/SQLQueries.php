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

    public function storeMessage()
    {
        $query_string  = "INSERT INTO messages ";
        $query_string .= "SET ";
        $query_string .= "id = NULL, ";
        $query_string .= "source = :source, ";
        $query_string .= "destination = :dest, ";
        $query_string .= "date = :date, ";
        $query_string .= "type = :type, ";
        $query_string .= "message = :message;";
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
