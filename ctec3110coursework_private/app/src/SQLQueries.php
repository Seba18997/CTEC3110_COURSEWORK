<?php

namespace M2MAPP;

class SQLQueries
{
    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    /**
     * @return string
     */
    public function getUsernamePasswordRole()
    {
        $query_string  = "SELECT user_name, password, role ";
        $query_string .= "FROM user_data ";
        $query_string .= "WHERE user_name = :username ;";
        return $query_string;
    }

    /**
     * @return string
     */
    public function getMessages()
    {
        $query_string  = "SELECT id, source, destination, date, type, message ";
        $query_string .= "FROM messages ";
        $query_string .= "WHERE date != '' ";
        $query_string .= "ORDER BY id DESC;";
        return $query_string;
    }

    /**
     * @return string
     */
    public function getNewestMessage()
    {
        $query_string  = "SELECT message ";
        $query_string .= "FROM messages ";
        $query_string .= "WHERE date != '' ";
        $query_string .= "ORDER BY id DESC ";
        $query_string .= "LIMIT 1;";
        return $query_string;
    }

    /**
     * @return string
     */
    public function getSwitchStates()
    {
        $query_string = "SELECT id, switch1, switch2, switch3, switch4, fan, heater, keypad ";
        $query_string .= "FROM switch ";
        $query_string .= "WHERE id=1;";
        return $query_string;
    }

    /**
     * @param $range
     * @return string
     */
    public function deleteMessages($range)
    {
        $query_string = "DELETE FROM messages ";
        $query_string .= "WHERE id ";
        $query_string .= "BETWEEN 1 AND $range;";
        return $query_string;
    }

    /**
     * @return string
     */
    public function setAIFromOneM()
    {
        $query_string = "ALTER TABLE messages AUTO_INCREMENT = 1;";
        return $query_string;
    }

    /**
     * @return string
     */
    public function setAIFromOneR()
    {
        $query_string = "ALTER TABLE user_data AUTO_INCREMENT = 1;";
        return $query_string;
    }

    /**
     * @return string
     */
    public function storeMessage()
    {
        $query_string  = 'INSERT INTO messages ( id, source, destination, date, type, message ) VALUES ( NULL, :source, :destination, :date, :type, :message );';
        return $query_string;
    }

    /**
     * @return string
     */
    public function updateSwitchState()
    {
        $query_string =  "UPDATE switch " ;
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

    /**
     * @return string
     */
    public function getSettings()
    {
        $query_string =  'SELECT app_name, wsdl, wsdl_username, wsdl_password, wsdl_messagecounter, db_host, db_name, db_port, db_user, db_userpassword, db_charset, db_collation, doctrine_driver FROM settings WHERE id=1; ';
        return $query_string;
    }

    /**
     * @return string
     */
    public function updateSettings()
    {
        $query_string =  "UPDATE settings " ;
        $query_string .= "SET app_name = CASE WHEN :app_name IS NOT NULL AND LENGTH(:app_name) > 0 THEN :app_name ELSE app_name END, " ;
        $query_string .= "wsdl = CASE WHEN :wsdl IS NOT NULL AND LENGTH(:wsdl) > 0 THEN :wsdl ELSE wsdl END, " ;
        $query_string .= "wsdl_username = CASE WHEN :wsdl_username IS NOT NULL AND LENGTH(:wsdl_username) > 0 THEN :wsdl_username ELSE wsdl_username END, " ;
        $query_string .= "wsdl_password = CASE WHEN :wsdl_password IS NOT NULL AND LENGTH(:wsdl_password) > 0 THEN :wsdl_password ELSE wsdl_password END, " ;
        $query_string .= "wsdl_messagecounter = CASE WHEN :wsdl_messagecounter IS NOT NULL AND LENGTH(:wsdl_messagecounter) > 0 THEN :wsdl_messagecounter ELSE wsdl_messagecounter END, " ;
        $query_string .= "db_host = CASE WHEN :db_host IS NOT NULL AND LENGTH(:db_host) > 0 THEN :db_host ELSE db_host END, " ;
        $query_string .= "db_name = CASE WHEN :db_name IS NOT NULL AND LENGTH(:db_name) > 0 THEN :db_name ELSE db_name END, ";
        $query_string .= "db_port = CASE WHEN :db_port IS NOT NULL AND LENGTH(:db_port) > 0 THEN :db_port ELSE db_port END, ";
        $query_string .= "db_user = CASE WHEN :db_user IS NOT NULL AND LENGTH(:db_user) > 0 THEN :db_user ELSE db_user END, ";
        $query_string .= "db_userpassword = CASE WHEN :db_userpassword IS NOT NULL AND LENGTH(:db_userpassword) > 0 THEN :db_userpassword ELSE db_userpassword END, ";
        $query_string .= "db_charset = CASE WHEN :db_charset IS NOT NULL AND LENGTH(:db_charset) > 0 THEN :db_charset ELSE db_charset END, ";
        $query_string .= "db_collation = CASE WHEN :db_collation IS NOT NULL AND LENGTH(:db_collation) > 0 THEN :db_collation ELSE db_collation END, ";
        $query_string .= "doctrine_driver = CASE WHEN :doctrine_driver IS NOT NULL AND LENGTH(:doctrine_driver) > 0 THEN :doctrine_driver ELSE doctrine_driver END ";
        $query_string .= "WHERE id=1;";
        return $query_string;

    }

    /**
     * @return string
     */
    public function getUserData(){
        $query_string =  'SELECT auto_id, user_name, email, role, timestamp ';
        $query_string .= 'FROM user_data ';
        return $query_string;
    }

    /**
     * @return string
     */
    public function updateUserData(){
        $query_string =  "UPDATE user_data " ;
        $query_string .= "SET user_name = CASE WHEN :user_name IS NOT NULL AND LENGTH(:user_name) > 0 THEN :user_name ELSE user_name END, " ;
        $query_string .= "email = CASE WHEN :email IS NOT NULL AND LENGTH(:email) > 0 THEN :email ELSE email END, " ;
        $query_string .= "role = CASE WHEN :role IS NOT NULL AND LENGTH(:role) > 0 THEN :role ELSE role END " ;
        $query_string .= "WHERE auto_id = :id;";
        return $query_string;
    }

    /**
     * @return string
     */
    public function updateUserRole(){
        $query_string =  "UPDATE user_data " ;
        $query_string .= "SET role = :role " ;
        $query_string .= "WHERE auto_id = :id;";
        return $query_string;
    }

}



