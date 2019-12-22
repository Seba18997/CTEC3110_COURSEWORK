<?php


namespace M2MAPP {

    class SoapWrapper
    {
        public function __construct()
        {

        }
        public function __destruct()
        {

        }

        public function createSoapClient()
        {
            $soap_client_handle = false;
            $soap_client_parameters = array();
            $exception = '';
            $wsdl = WSDL;

            $soap_client_parameters = ['trace' => true, 'exceptions' => true];

            try
            {
                $soap_client_handle = new \SoapClient($wsdl, $soap_client_parameters);
            }
            catch (\SoapFault $exception)
            {
                $soap_client_handle = 'Ooops - something went wrong connecting to the data supplier.  Please try again later';
            }
            return $soap_client_handle;
        }

        /**
         * @param $soap_client
         * @param $messages_counter
         * @return array
         */
        public function getMessagesFromSoap($soap_client, $messages_counter)
        {
            $soap_call_result = null;
            $username = USERNAME;
            $password = PASSWORD;

            if ($soap_client)
            {
                try
                {
                    $soap_call_result = $soap_client->peekMessages($username, $password, $messages_counter, "");
                }
                catch (\SoapFault $exception)
                {
                    echo 'Oops - something went wrong connecting to the data supplier.  Please try again later';
                }
            }

            return $soap_call_result;
        }


    }
}