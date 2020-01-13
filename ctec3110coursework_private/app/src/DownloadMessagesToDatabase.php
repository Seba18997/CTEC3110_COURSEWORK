<?php

namespace M2MAPP;

class DownloadMessagesToDatabase
{
    private $downloaded_messages_data;
    private $message_counter;
    private $database_wrapper;
    private $database_connection_settings;
    private $sql_queries;

    public function __construct()
    {
            $this->database_wrapper = NULL;
            $this->sql_queries = NULL;
            $this->downloaded_messages_data = array();
            $this->message_counter = NULL;
    }

    public function __destruct(){
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

    public function setMsgCounter($message_counter)
    {
        $this->message_counter = $message_counter;
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
            $messages = (new SoapWrapper)->getMessagesFromSoap($this->setSoapClient(), MESSAGES_COUNTER);
            return $messages;
    }

    public function getMessagesResult()
    {
            return $this->downloaded_messages_data;
    }

    public function setMessagesCounter()
    {
        $counter = (new SoapWrapper)->getCountOfNotNullRowsInSoapResponse();
        return $counter;
    }

    public function prepareMessagesToStore()
    {
            $messages_final_result = [];

            $message_result = $this->retrieveMessages();

            for ($i=0;$i<$this->message_counter;$i++) {
                $messages_final_result['source'][$i] =
                    (new Validator)->validateDownloadedMessage(
                        (new Helper)->mapDataFromString($message_result[$i], 'sourcemsisdn'));

                $messages_final_result['destination'][$i] =
                    (new Validator)->validateDownloadedMessage(
                        (new Helper)->mapDataFromString($message_result[$i], 'destinationmsisdn'));

                $messages_final_result['date'][$i] =
                    (new Validator)->validateDownloadedMessage(
                        (new Helper)->mapDataFromString($message_result[$i], 'receivedtime'));

                $messages_final_result['type'][$i] =
                    (new Validator)->validateDownloadedMessage(
                        (new Helper)->mapDataFromString($message_result[$i], 'bearer'));

                $messages_final_result['message'][$i] =
                        (new Validator)->validateDownloadedMessage(
                            (new Helper)->mapDataFromString($message_result[$i], 'message'));
            }
            $this->downloaded_messages_data = $messages_final_result;
            return 'Messages successfully prepared.';
    }

    public function addPreparedMessages()
    {
            $messages_exists = NULL;

            $sql_query_get_all_messages = $this->sql_queries->getMessages();

            $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

            $this->database_wrapper->makeDatabaseConnection();

            $this->database_wrapper->safeQuery($sql_query_get_all_messages);

            $number_of_rows = $this->database_wrapper->countRows();

            if ($number_of_rows < $this->setMessagesCounter())
            {
                $messages_exists = 'Messages are not in DB. Adding now...';

                  for($i=0; $i<$this->setMessagesCounter(); $i++)
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
            else if ($number_of_rows === $this->setMessagesCounter())
            {
                 $messages_exists = 'Messages have been already added';
            }
            else if ($number_of_rows > $this->setMessagesCounter())
            {
                $messages_exists = 'Probably cloned messages in DB';
            }
            else
            {
                 $messages_exists = 'Problem with addPreparedMessages' ;
            }

            return $messages_exists;
    }

}
