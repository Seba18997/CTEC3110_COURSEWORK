<?php


namespace M2MAPP;


class UsersModel
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

    public function getUsersData()
    {
        $users_data = [];

        $sql_query_user_data = $this->sql_queries->getUserData();

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $this->database_wrapper->safeQuery($sql_query_user_data);

        $number_of_data_sets = $this->database_wrapper->countRows();

        if ($number_of_data_sets >= 1)
        {
            $x = 0;

            while ($x < $number_of_data_sets ) {

                $row = $this->database_wrapper->safeFetchArray();

                $users_data[$x]['id'] = $row['auto_id'];
                $users_data[$x]['username'] = $row['user_name'];
                $users_data[$x]['email'] = $row['email'];
                $users_data[$x]['role'] = $row['role'];
                $users_data[$x]['date'] = strval($row['timestamp']);

                $x++;
            }
        }
        else
        {
            $final_user_data[0] = 'Something is wrong';
        }

        $final_user_data['retrieved_users_data'] = $users_data;
        $final_user_data['amount_of_users'] = $number_of_data_sets;

        return $final_user_data;
    }

    public function changeUserData($final_changes=[])
    {
        $query_string = $this->sql_queries->updateUserData();

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $query_parameters =
            array(':user_name' => $final_changes['username'],
                ':email' => $final_changes['email'],
                ':role' => $final_changes['role'],
                ':id' => $final_changes['id']);

        if(!empty($final_changes['id']))
        {
            $this->database_wrapper->safeQuery($query_string, $query_parameters);
            return true;
        }
        else
        {
            return false;
        }
    }

}