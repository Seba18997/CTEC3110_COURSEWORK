<?php

namespace M2MAPP;

class MessagesModel
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
     * @return array
     */
    public function getMessagesFromDB()
    {
        $messages_to_show = [];

        $query_string = $this->sql_queries->getMessages();

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $this->database_wrapper->safeQuery($query_string);

        $number_of_data_sets = $this->database_wrapper->countRows();

        if ($number_of_data_sets >= 0) {
            $x = 0;
            
            while ($x < $number_of_data_sets ) {

                $row = $this->database_wrapper->safeFetchArray();

                $finalmessages[$x]['id'] = $row['id'];
                $finalmessages[$x]['source'] = $row['source'];
                $finalmessages[$x]['destination'] = $row['destination'];
                $finalmessages[$x]['date'] = $row['date'];
                $finalmessages[$x]['type'] = $row['type'];
                $finalmessages[$x]['message'] = html_entity_decode($row['message']);

                $x++;
            }
        } else {
            $messages_to_show[0] = 'No messages found or there are 0 messages in the database.';
        }

        $messages_to_show['number_of_messages_data_sets'] = $number_of_data_sets;
        $messages_to_show['retrieved_messages'] = $finalmessages;

        return $messages_to_show;
    }

    /**
     * @return mixed
     */
    public function getNewestMessageFromDB()
    {

        $query_string = $this->sql_queries->getNewestMessage();

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $this->database_wrapper->safeQuery($query_string);

        $row = $this->database_wrapper->safeFetchArray();

        $message_content = $row['message'];

        return $message_content;
    }

}