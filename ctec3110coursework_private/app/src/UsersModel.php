<?php


namespace M2MAPP;


class UsersModel
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

    /**
     * @param $sql_queries
     */
    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    public function makeConnection()
    {
        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();
    }

    /**
     * @return mixed
     */
    public function getUsersData()
    {
        $users_data = [];

        $sql_query_user_data = $this->sql_queries->getUserData();

        $this->makeConnection();

        $this->database_wrapper->safeQuery($sql_query_user_data);

        $number_of_data_sets = $this->database_wrapper->countRows();

        if ($number_of_data_sets >= 1) {
            $x = 0;

            while ($x < $number_of_data_sets ) {

                $row = $this->database_wrapper->safeFetchArray();

                $users_data[$x]['id'] = $row['auto_id']; // id from database
                $users_data[$x]['username'] = $row['user_name'];
                $users_data[$x]['email'] = $row['email'];
                $users_data[$x]['role'] = $row['role'];
                $users_data[$x]['date'] = strval($row['timestamp']);

                $x++;
            }
        } else {
            $final_user_data[0] = 'Something is wrong';
        }

        $final_user_data['retrieved_users_data'] = $users_data;
        $final_user_data['amount_of_users'] = $number_of_data_sets;

        return $final_user_data;
    }

    /**
     * @param $desiredrole
     * @param $userid
     * @return bool
     */
    public function changeUserRole($desiredrole, $userid)
    {
        $query_string_change = $this->sql_queries->updateUserRole();

        $this->makeConnection();

        $query_parameters =
            array(':role' => $desiredrole,
                ':id' => $userid);

        if (!empty($userid) && !empty($desiredrole)) {
            $this->database_wrapper->safeQuery($query_string_change, $query_parameters);
            return true;
        } else {
            return false;
        }

    }

}
