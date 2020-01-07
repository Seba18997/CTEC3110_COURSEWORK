<?php

namespace M2MAPP;

class DownloadMessagesToDatabase
{

    private $database_wrapper;
    private $make_query;
    private $downloaded_messages_data;
    private $message_counter;

    public function __construct()
    {
            $this->database_wrapper = null;
            $this->make_query = null;
            $this->downloaded_messages_data = array();
            $this->message_counter = MESSAGES_COUNTER;
    }

    public function __destruct(){
    }

    public function makeConnection()
    {
            $connection = (new DatabaseWrapper)->makeDatabaseConnection();
            return $connection;
    }

    public function makeQuery($make_query)
    {
        $this->make_query = $make_query;
    }

    public function doMakeQuery($query, $params='')
    {
        $make_query = (new DatabaseWrapper)->safeQuery($query, $params);
        return $make_query;
    }

    public function setSoapClient()
    {
            $soap_client = NULL;
            $soap_client = (new SoapWrapper)->createSoapClient();
            return $soap_client;
    }

    public function retrieveMessages()
    {
            $messages = NULL;
            $messages = (new SoapWrapper)->getMessagesFromSoap($this->setSoapClient(), $this->message_counter);
            return $messages;
    }

    public function getMessagesResult()
    {
            return $this->downloaded_messages_data;
    }

    public function storeDownloadedMessages()
    {
            $this->prepareMessagesToStore();
            $this->addMessageIfNotExist();
    }

    private function prepareMessagesToStore()
    {
            $messages_final_result = [];

            $message_result = $this->retrieveMessages();

            for ($i=0;$i<$this->message_counter;$i++) {
                $messages_final_result['source'][$i] = (new Validator)->validateDownloadedMessage((new Helper)->mapDataFromString($message_result[$i], 'sourcemsisdn'));
                $messages_final_result['destination'][$i] = (new Validator)->validateDownloadedMessage((new Helper)->mapDataFromString($message_result[$i], 'destinationmsisdn'));
                $messages_final_result['date'][$i] = (new Validator)->validateDownloadedMessage((new Helper)->mapDataFromString($message_result[$i], 'receivedtime'));
                $messages_final_result['type'][$i] = (new Validator)->validateDownloadedMessage((new Helper)->mapDataFromString($message_result[$i], 'bearer'));
                $messages_final_result['message'][$i] = (new Validator)->validateDownloadedMessage((new Helper)->mapDataFromString($message_result[$i], 'message'));
            }

            $this->downloaded_messages_data = $messages_final_result;
    }

    public function addMessageIfNotExist()
    {
            $messages_exists = NULL;

            $this->makeConnection();

            $sql_query_get_all_messages = (new SQLQueries)->getMessages();

            $query_handle = $this->doMakeQuery($sql_query_get_all_messages);

            $number_of_rows = $query_handle->countRows();

            $size_of_array = (new Helper)->getSizeofArray($this->downloaded_messages_data);

            //$sql_query_check_if_message_exists = (new SQLQueries)->checkIfMessageExists();

            $sql_query_insert_messages = (new SQLQueries)->storeMessage();

            if ($number_of_rows < $size_of_array)
            {
                $messages_exists = false;

                $i = 0;

                while ($i == $size_of_array)
                {
                    $source = $this->downloaded_messages_data['source'][$i];
                    $dest = $this->downloaded_messages_data['destination'][$i];
                    $date = $this->downloaded_messages_data['date'][$i];
                    $type = $this->downloaded_messages_data['type'][$i];
                    $message = $this->downloaded_messages_data['message'][$i];

                    $query_parameters =
                        array(':source' => $source, ':destination' => $dest, ':date' => $date, ':type' => $type, ':message' => $message);

                    $this->doMakeQuery($sql_query_insert_messages, $query_parameters);

                    echo 'added ' .$i. ' record' ;
                }
            }
            else if ($number_of_rows == $size_of_array)
            {
                 $messages_exists = true;
            }
            else
            {
                 echo 'something went wrong' ;
            }

            return $messages_exists;
    }

}
