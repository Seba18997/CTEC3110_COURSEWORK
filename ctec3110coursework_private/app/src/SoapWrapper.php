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
            $soap_server_connection_result = true;
        }
        catch (\SoapFault $exception)
        {
            $soap_client_handle = 'Ooops - something went wrong connecting to the data supplier.  Please try again later';
        }
        return $soap_client_handle;
    }

    public function getSoapData($soap_client)
    {
        $soap_call_result = null;
        $username = USERNAME;
        $password = PASSWORD;

            function get_string_between($string, $start, $end)
            {
                $string = ' ' . $string;
                $ini = strpos($string, $start);
                if ($ini == 0) return '';
                $ini += strlen($start);
                $len = strpos($string, $end, $ini) - $ini;
                return substr($string, $ini, $len);
            }

             if ($soap_client)
             {
                try
                {
                    $soap_call_result = $soap_client->peekMessages($username, $password, 100, "");
                    $filteredArray = (array_filter($soap_call_result, function($k) {
                        return $k == 37;
                    }, ARRAY_FILTER_USE_KEY));
                    //echo json_encode($filteredArray);
                    $str = json_encode($filteredArray);

                    //SMS message format: switch1:onswitch2:onswitch3:offswitch4:onfan:forward
                    // heater:3keypad:4id:19-3110-AZ
                    //
                    $parsed = get_string_between($str, 'switch1:', 'switch2');
                    $parsed1 = get_string_between($str, 'switch2:', 'switch3');
                    $parsed2 = get_string_between($str, 'switch3:', 'switch4');
                    $parsed3 = get_string_between($str, 'switch4:', 'fan');
                    $parsed4 = get_string_between($str, 'fan:', 'heater');
                    $parsed5 = get_string_between($str, 'heater:', 'keypad');
                    $parsed6 = get_string_between($str, 'keypad:', 'id');
                    $parsed7 = get_string_between($str, 'id:', 'Z');
                    echo "Switch1: $parsed Switch2: $parsed1 Switch3: $parsed2
                    Switch4: $parsed3 Fan: $parsed4 Heater: $parsed5 Keypad: $parsed6
                    ID: $parsed7";

                }
                catch (\SoapFault $exception)
                {
                    echo 'Oops - something went wrong connecting to the data supplier.  Please try again later';
                }
             }

            return $soap_call_result;
        }


}