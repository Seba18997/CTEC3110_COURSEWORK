<?php
$wsdl = "https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl";
$username = "19_Sebastian";
$password = "passXDword123";
$key = 1;

try
{
    $soap_client_handle = new SoapClient($wsdl);
    $soap_call_result = $soap_client_handle->peekMessages($username, $password, 10, "");
    var_dump($soap_call_result);

    foreach($soap_call_result as $key=>$item){
        echo "Message number $key => $item <br>";
    }


    $sourcemsisdn = substr($soap_call_result,0,11);
    $destinationmsisdn = substr($soap_call_result,12,23);
    $receivedtime = substr($soap_call_result, );
    $bearer = substr($soap_call_result, );
    $messageref = substr($soap_call_result, );
    $message = substr($soap_call_result, );

echo $sourcemsisdn . '' . $destinationmsisdn . '' .$receivedtime . '' .$bearer . '' .$messageref . '' .$message . '' .

}
catch (SoapFault $exception)
{
    trigger_error($exception);
}

