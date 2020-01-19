<?php

namespace M2MAPP;

class DownloadMessagesToDatabase
{
    private $downloaded_messages_data;
    private $message_counter;
    private $database_wrapper;
    private $database_connection_settings;
    private $sql_queries;
    private $soap_response;

    public function __construct()
    {
            $this->database_wrapper = NULL;
            $this->sql_queries = NULL;
            $this->downloaded_messages_data = array();
            $this->message_counter = NULL;
            $this->soap_response = NULL;
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
     * @param $message_counter
     */
    public function setMsgCounter($message_counter)
    {
        $this->message_counter = $message_counter;
    }

    /**
     * @param $soap_response
     */
    public function setSoapResponse($soap_response)
    {
        $this->soap_response = $soap_response;
    }

    /**
     * @return mixed
     */
    public function countMessagesinDB()
    {

        $sql_query_get_all_messages = $this->sql_queries->getMessages();

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $this->database_wrapper->safeQuery($sql_query_get_all_messages);

        $number_of_rows = $this->database_wrapper->countRows();

        return $number_of_rows;
    }

    /**
     * @return bool
     */
    public function prepareMessagesToStore()
    {
            $messages_final_result = [];

            $message_result = $this->soap_response;

            $validator = new Validator();

            $helper = new Helper();

            for ($i=0;$i<$this->message_counter;$i++) {
                $messages_final_result['source'][$i] =
                    $validator->sanitiseString(
                        $helper->mapDataFromString($message_result[$i], 'sourcemsisdn'));

                $messages_final_result['destination'][$i] =
                    $validator->sanitiseString(
                        $helper->mapDataFromString($message_result[$i], 'destinationmsisdn'));

                $messages_final_result['date'][$i] =
                    $validator->sanitiseString(
                        $helper->mapDataFromString($message_result[$i], 'receivedtime'));

                $messages_final_result['type'][$i] =
                    $validator->sanitiseString(
                        $helper->mapDataFromString($message_result[$i], 'bearer'));

                $messages_final_result['message'][$i] =
                    $validator->sanitiseString(
                        $helper->mapDataFromString($message_result[$i], 'message'));
            }
            $this->downloaded_messages_data = $messages_final_result;
            return true;
    }

    public function addPreparedMessages()
    {
          for($i=0; $i<$this->message_counter; $i++)
          {
                $source = $this->downloaded_messages_data['source'][$i];
                $dest = $this->downloaded_messages_data['destination'][$i];
                $date = $this->downloaded_messages_data['date'][$i];
                $type = $this->downloaded_messages_data['type'][$i];
                $message = $this->downloaded_messages_data['message'][$i];

                $query_parameters =
                    array(':source' => $source,
                          ':destination' => $dest,
                          ':date' => $date,
                          ':type' => $type,
                          ':message' => $message);

                $sql_query_store_messages = $this->sql_queries->storeMessage();

                $this->database_wrapper->safeQuery($sql_query_store_messages, $query_parameters);
           }

    }

    public function prepareDatabase(){

        $sql_set_auto_increment = $this->sql_queries->setAIFromOneM();

        $sql_delete_previous_messages = $this->sql_queries->deleteMessages(($this->message_counter) - 1);

        $this->database_wrapper->safeQuery($sql_delete_previous_messages);

        $this->database_wrapper->safeQuery($sql_set_auto_increment);
    }

    /**
     * @return string
     */
    public function performMainOperation()
    {

        if ($this->countMessagesinDB() == 0 || $this->countMessagesinDB() < $this->message_counter) {
            $this->prepareDatabase();

            $this->prepareMessagesToStore();

            if ($this->prepareMessagesToStore() == true) {
                $this->addPreparedMessages();

                $result = 'Messages are not in DB. Adding now...';
            } else {
                $result = 'Error with prepareMessagesToStore()';
            }
        } elseif ($this->countMessagesinDB() == $this->message_counter) {
            $result = 'Messages have been already added';
        } else {
            $result = 'Problem with addPreparedMessages' ;
        }
        return $result;
    }

}
