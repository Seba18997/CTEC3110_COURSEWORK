<?php


namespace M2MAPP;


class Authentication
{
    private $database_wrapper;
    private $database_connection_settings;
    private $sql_queries;

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * @param $database_wrapper
     */

    public function setDatabaseWrapper($database_wrapper)
    {
        $this->database_wrapper = $database_wrapper;
    }

    /**
     * @param $database_connection_settings
     */

    public function setDatabaseConnectionSettings($database_connection_settings)
    {
        $this->database_connection_settings = $database_connection_settings;
    }

    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    public function getUsernamePassword($cos)
    {
        $username = $cos;
        $query_string = $this->sql_queries->getUsernamePassword($username);

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $this->database_wrapper->safeQuery($query_string);

        if ($row = $this->database_wrapper->safeFetchArray()) {
            $params['username'] = $row['user_name'];
            $params['password'] = $row['password'];
        } else {
            $params = 1;
        }

        $final = $params;

        return $final;
    }
}