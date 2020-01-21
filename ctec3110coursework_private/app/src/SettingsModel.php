<?php


namespace M2MAPP;


class SettingsModel
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

    /**
     *
     */
    public function makeConnection()
    {

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

    }

    /**
     * @return mixed
     */
    public function getSettingsFromDB()
    {
        $settings = [];

        $query_string_get = $this->sql_queries->getSettings();

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $this->database_wrapper->safeQuery($query_string_get);

        $number_of_data_sets = $this->database_wrapper->countRows();

        if ($number_of_data_sets === 1) {
            while ($row = $this->database_wrapper->safeFetchArray()) {
                $settings['app_name'] = $row['app_name'];
                $settings['wsdl'] = $row['wsdl'];
                $settings['wsdl_username'] = $row['wsdl_username'];
                $settings['wsdl_password'] = $row['wsdl_password'];
                $settings['wsdl_messagecounter'] = $row['wsdl_messagecounter'];
                $settings['db_host'] = $row['db_host'];
                $settings['db_name'] = $row['db_name'];
                $settings['db_port'] = $row['db_port'];
                $settings['db_user'] = $row['db_user'];
                $settings['db_userpassword'] = $row['db_userpassword'];
                $settings['db_charset'] = $row['db_charset'];
                $settings['db_collation'] = $row['db_collation'];
                $settings['doctrine_driver'] = $row['doctrine_driver'];
            }
        } else {
            $final_settings[0] = 'Something is wrong';
        }

        $final_settings['settings'] = $settings;

        return $final_settings;
    }

    /**
     * @param array $final_settings
     */
    public function updateSettings($final_settings=[]){

        $query_string_update = $this->sql_queries->updateSettings();

        $this->makeConnection();

        $query_parameters =
            array(':app_name' => $final_settings['app_name'],
                ':wsdl' => $final_settings['wsdl'],
                ':wsdl_username' => $final_settings['wsdl_username'],
                ':wsdl_password' => $final_settings['wsdl_password'],
                ':wsdl_messagecounter' => $final_settings['wsdl_messagecounter'],
                ':db_host'  => $final_settings['db_host'],
                ':db_name'  => $final_settings['db_name'],
                ':db_port'  => $final_settings['db_port'],
                ':db_user'  => $final_settings['db_user'],
                ':db_userpassword'  => $final_settings['db_userpassword'],
                ':db_charset'  => $final_settings['db_charset'],
                ':db_collation'  => $final_settings['db_collation'],
                ':doctrine_driver'  => $final_settings['doctrine_driver']);

        $this->database_wrapper->safeQuery($query_string_update, $query_parameters);
    }


}