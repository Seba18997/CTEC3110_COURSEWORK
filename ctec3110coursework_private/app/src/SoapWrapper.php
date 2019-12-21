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
                //var_dump($soap_call_result);
                function get_string_between($string, $start, $end)
                {
                    $string = ' ' . $string;
                    $ini = strpos($string, $start);
                    if ($ini == 0) return '';
                    $ini += strlen($start);
                    $len = strpos($string, $end, $ini) - $ini;
                    return substr($string, $ini, $len);
                }

                $filteredArray = (array_filter($soap_call_result, function($k) {
                    return $k == 37;
                }, ARRAY_FILTER_USE_KEY));

                //echo json_encode($filteredArray);
                $str = json_encode($filteredArray);

                //SMS message format: "switch1:onswitch2:onswitch3:offswitch4:onfan:forward
                // heater:3keypad:4id:19-3110-AZ"

                $switch1     = get_string_between($str, 'switch1:', 'switch2');
                $switch2     = get_string_between($str, 'switch2:', 'switch3');
                $switch3     = get_string_between($str, 'switch3:', 'switch4');
                $switch4     = get_string_between($str, 'switch4:', 'fan');
                $fan         = get_string_between($str, 'fan:',     'heater');
                $heater      = get_string_between($str, 'heater:',  'keypad');
                $keypad      = get_string_between($str, 'keypad:',  'id');
                $group_id     = get_string_between($str, 'id:',      'Z');


               echo "Switch1: $switch1 Switch2: $switch2 Switch3: $switch3 Switch4: $switch4 Fan: $fan Heater: $heater Keypad: $keypad ID: $group_id";



            }
            catch (\SoapFault $exception)
            {
                echo 'Oops - something went wrong connecting to the data supplier.  Please try again later';
            }
         }

        return $soap_call_result;
    }


}