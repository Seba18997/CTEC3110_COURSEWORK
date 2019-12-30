<?php

namespace M2MAPP;

class DownloadMessagesToDatabase
{

    private $database_handle;
    private $soap_handle;
    private $downloaded_messages_data;
    private $database_connection_messages;
    private $message_counter;

    public function __construct()
    {
        $this->database_handle = null;
        $this->soap_handle = null;
        $this->downloaded_messages_data = array();
        $this->database_connection_messages = array();
        $this->message_counter = MESSAGES_COUNTER;
    }

    public function __destruct(){

    }

    public function set_database_handle($database_handle_object)
    {
        $this->database_handle = $database_handle_object;
    }

    public function get_messages_from_soap()
    {
        $this->soap_handle = SoapWrapper::getMessagesFromSoap($this->createSoapClient(), $this->message_counter);
    }

    public function get_downloaded_messages_result()
    {
        return $this->downloaded_messages_data;
    }

    public function storeDownloadedMessages()
    {
        if ($this->downloaded_messages_data['message-available'])
        {
            $this->prepareMessagesToStore();

            if (!$this->checkIfMessageIsStored())
            {
                $this->storeNewMessage();
            }

        }
    }

    private function prepareMessagesToStore()
    {
        $database_connection_error = $this->database_connection_messages['database-connection-error'];

        if (!$database_connection_error)
        {
            $messages_final_result = [];

            $messages_result = $this->get_messages_from_soap();

            for ($i=0;$i<$this->message_counter;$i++) {
                $messages_final_result['source'][$i] = mapDataFromString($messages_result[$i], 'sourcemsisdn');
                $messages_final_result['destination'][$i] = mapDataFromString($messages_result[$i], 'destinationmsisdn');
                $messages_final_result['date'][$i] = mapDataFromString($messages_result[$i], 'receivedtime');
                $messages_final_result['type'][$i] = mapDataFromString($messages_result[$i], 'bearer');
                $messages_final_result['message'][$i] = mapDataFromString($messages_result[$i], 'message');
            }
            $this->downloaded_messages_data = $messages_final_result;
        }
    }

    private function checkIfMessageIsStored()
    {

        for ($i=0;$i<$this->message_counter;$i++) {
            $source = $this->downloaded_messages_data['source'][$i];
            $dest = $this->downloaded_messages_data['destination'][$i];
            $date = $this->downloaded_messages_data['date'][$i];
            $type = $this->downloaded_messages_data['type'][$i];
            $message = $this->downloaded_messages_data['message'][$i];
        }

        $sql_query_string = SQLQueries::checkIfMessageExists();

        $arr_sql_query_parameters =
            array(':source' => $source, ':destination' => $dest, ':date' => $date, ':type' => $type, ':message' => $message);

        $this->database_handle->safe_query($sql_query_string, $arr_sql_query_parameters);

        $number_of_rows = $this->database_handle->count_rows();

        $message_exists = false;
        if ($number_of_rows > 0)
        {
            $message_exists = true;
        }
        return $message_exists;
    }

    private function storeNewMessage()
    {
        $source = $this->downloaded_messages_data['source'][$i];
        $dest = $this->downloaded_messages_data['destination'][$i];
        $date = $this->downloaded_messages_data['date'][$i];
        $type = $this->downloaded_messages_data['type'][$i];
        $message = $this->downloaded_messages_data['message'][$i];

        $sql_query_string = SQLQueries::storeMessage();

        $arr_sql_query_parameters =
            array('source' => $source, ':destination' => $dest, ':date' => $date, ':type' => $type, ':message' => $message);


        $arr_database_execution_messages = $this->database_handle->safe_query($sql_query_string, $arr_sql_query_parameters);
        $new_message_stored = false;

        if ($arr_database_execution_messages['execute-OK'])
        {
            $new_message_stored = true;
        }
        $this->downloaded_messages_data['message-stored']= $new_message_stored;
    }

}
