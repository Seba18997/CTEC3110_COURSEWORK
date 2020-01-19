<?php


namespace M2MAPP;


class SettingsSetup
{
    public function __construct()
    {

    }
    public function __destruct()
    {

    }

    /**
     * @return array
     */
    public function databaseConnection()
    {
        $settings = [
                'pdo_settings' => [
                    'rdbms' => 'mysql',
                    'host' => 'localhost',
                    'dbname' => 'coursework',
                    'port' => '3306',
                    'username' => 'p3tuser',
                    'userpassword' => 'password',
                    'charset' => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    ]];
        return $settings;
    }

    /**
     * @return mixed
     */
    public function getSettingsFromDB()
    {
        $settings_model = new SettingsModel();
        $settings_model->setDatabaseWrapper(new DatabaseWrapper);
        $settings_model->setSqlQueries(new SQLQueries);
        $settings_model->setDatabaseConnectionSettings($this->databaseConnection()['pdo_settings']);
        $final_settings = $settings_model->getSettingsFromDB();
        return $final_settings;
    }

}