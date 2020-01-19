<?php

namespace M2MAPP;

class SoapWrapper
{
    public function __construct()
    {

    }
    public function __destruct()
    {

    }

    /**
     * @return bool|\SoapClient|string
     */
    public function createSoapClient()
    {
        $soap_client_handle = false;
        $soap_client_parameters = array();
        $exception = '';
        $wsdl = WSDL;

        $soap_client_parameters = ['trace' => true, 'exceptions' => true];

        try {
            $soap_client_handle = new \SoapClient($wsdl, $soap_client_parameters);
        } catch (\SoapFault $exception) {
            $soap_client_handle = 'createSoapClient : Ooops - something went wrong connecting to the data supplier.  Please try again later <br/>';
        }
        return $soap_client_handle;
    }

    /**
     * @param $soap_client
     * @param $messages_counter
     * @return null
     */
    public function getMessagesFromSoap($soap_client, $messages_counter)
    {
        $soap_call_result = null;
        $username = USERNAME;
        $password = PASSWORD;

        if ($soap_client) {
            try {
                $soap_call_result = $soap_client->peekMessages($username, $password, $messages_counter, "");
            } catch (\SoapFault $exception) {
                echo 'getMessagesFromSoap : Oops - something went wrong connecting to the data supplier.  Please try again later <br/>';
            }
        }

        return $soap_call_result;
    }

    /**
     * @return int
     */
    public function getCountOfNotNullRowsInSoapResponse(){
        $count = (new Helper)->countRowsInArray($this->getMessagesFromSoap($this->createSoapClient(), MESSAGES_COUNTER));
        return $count;
    }

}
