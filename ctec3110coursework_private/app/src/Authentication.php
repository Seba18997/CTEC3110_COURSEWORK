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

    public function getParamsDb($username)
    {
        $query_string = $this->sql_queries->getUsernamePasswordRole();

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $query_parameters = array(':username' => $username);

        $this->database_wrapper->safeQuery($query_string, $query_parameters);

        if ($row = $this->database_wrapper->safeFetchArray()) {
            $params['username'] = $row['user_name'];
            $params['password'] = $row['password'];
            $params['role']     = $row['role'];
        } else {
            $params[0] = 'Invalid_credentials';
        }

        return $params;
    }
}