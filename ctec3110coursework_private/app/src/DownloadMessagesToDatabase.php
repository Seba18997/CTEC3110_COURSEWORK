<?php

namespace M2MAPP;

class DownloadMessagesToDatabase
{
    private $database_handle;
    private $downloaded_messages_data;
    private $database_connection_messages;
    private $message_counter;

    public function __construct()
    {
        $this->database_handle = null;
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

    public function do_download_messages()
    {
        return $this->getMessagesFromSoap($this->createSoapClient(), $this->message_counter);
    }

    public function get_downloaded_messages_result()
    {
        return $this->downloaded_messages_data;
    }

    public function storeDownloadedStockData()
    {
        if ($this->downloaded_messages_data['soap-server-get-quote-result'])
        {
            if ($this->downloaded_messages_data['stock-data-available'])
            {
                $this->prepareStockData();
                if (!$this->doesCompanyExist())
                {
                    $this->storeNewCompanyDetails();
                }

                if (!$this->checkIfDataPreStored())
                {
                    $this->storeNewData();
                }
            }
        }
    }

    private function prepareMessagesToStore()
    {
        $database_connection_error = $this->database_connection_messages['database-connection-error'];

        if (!$database_connection_error)
        {
            $stock_date = $this->downloaded_messages_data['downloaded-company-data']['DATE'];
            $stock_time = $this->downloaded_messages_data['downloaded-company-data']['TIME'];

            $this->message_counter = $counter;

            $messages_final_result = [];

            $messages_model = $app->getContainer()->get('SoapWrapper');

            $message_connect = $messages_model->createSoapClient();

         //   $messages_result = $messages_model->getMessagesFromSoap($message_connect, $counter);

            $message_data_handle = $app->getContainer()->get('Helper');

            $this->do_download_messages() = $messages_result;

            $messages_final_result['source'] = mapDataFromString($messages_result[$i], 'sourcemsisdn');
            $messages_final_result['dest'] = mapDataFromString($messages_result[$i], 'destinationmsisdn');
            $messages_final_result['date'] = mapDataFromString($messages_result[$i], 'receivedtime');
            $messages_final_result['type'] = mapDataFromString($messages_result[$i], 'bearer');
            $messages_final_result['message'] = mapDataFromString($messages_result[$i], 'message');

            return $messages_final_result;

            $this->downloaded_messages_data = array_merge($this->downloaded_messages_data, $arr_prepared_quote_details);
        }
    }

    // check if company is already in the database
    private function isMessageDownloaded()
    {
        $sql_query_string = StockQuoteSqlQuery::check_company_symbol();
        $arr_sql_query_parameters = array(':stock_company_symbol' => $this->downloaded_messages_data['sanitised-$company_symbol']);

        $this->database_handle->safe_query($sql_query_string, $arr_sql_query_parameters);

        $number_of_rows = $this->database_handle->count_rows();

        $stock_company_exists = false;
        if ($number_of_rows > 0)
        {
            $stock_company_exists = true;
            $row = $this->database_handle->safe_fetch_array();
            $this->stock_company_name_id = $row['stock_company_name_id'];
        }

        return $stock_company_exists;
    }

    private function storeNewCompanyDetails()
    {
        $stock_symbol = $this->downloaded_messages_data['downloaded-company-data']['SYMBOL'];
        $stock_company_name = $this->downloaded_messages_data['downloaded-company-data']['NAME'];

        // add the new company's details
        $sql_query_string = StockQuoteSqlQuery::store_company_name();

        $arr_sql_query_parameters =
            array(':stock_company_symbol' => $stock_symbol,
                ':stock_company_name' => $stock_company_name);

        $arr_database_execution_messages = $this->database_handle->safe_query($sql_query_string, $arr_sql_query_parameters);

        if ($arr_database_execution_messages['execute-OK'])
        {
            $stock_company_name_stored = true;
            $this->stock_company_name_id = $this->database_handle->last_inserted_id();
        }
        else
        {
            $stock_company_name_stored = false;
        }
        $this->downloaded_messages_data['company-details-stored'] = $stock_company_name_stored;
    }

    // check to see if the data values exist in the stock values database table
    private function checkIfDataPreStored()
    {
        $this->reformatTimeString();
        $stock_symbol = $this->downloaded_messages_data['downloaded-company-data']['SYMBOL'];
        $stock_date = $this->downloaded_messages_data['stock-date'];
        $stock_time = $this->downloaded_messages_data['stock-time'];

        $sql_query_string = StockQuoteSqlQuery::does_company_exist();

        $arr_sql_query_parameters =
            array(':stock_company_symbol' => $stock_symbol,
                ':stock_date' => $stock_date,
                ':stock_time' => $stock_time);

        $this->database_handle->safe_query($sql_query_string, $arr_sql_query_parameters);

        $number_of_rows = $this->database_handle->count_rows();
        $stock_data_exists = false;
        if ($number_of_rows > 0)
        {
            $stock_data_exists = true;
        }
        return $stock_data_exists;
    }

    private function storeNewData()
    {
        $stock_date = $this->downloaded_messages_data['stock-date'];
        $stock_time = $this->downloaded_messages_data['stock-time'];
        $stock_last_value = $this->downloaded_messages_data['downloaded-company-data']['LAST'];
        $stock_company_name_id = $this->stock_company_name_id;

        $sql_query_string = StockQuoteSqlQuery::store_stock_data();

        $arr_sql_query_parameters =
            [':stock_date' => $stock_date,
                ':stock_time' => $stock_time,
                ':stock_last_value' => $stock_last_value,
                ':fk_company_stock_id' => $stock_company_name_id
            ];


        $arr_database_execution_messages = $this->database_handle->safe_query($sql_query_string, $arr_sql_query_parameters);
        $new_stock_data_stored = false;

        if ($arr_database_execution_messages['execute-OK'])
        {
            $new_stock_data_stored = true;
        }
        $this->downloaded_messages_data['stock-details-stored']= $new_stock_data_stored;
    }

}