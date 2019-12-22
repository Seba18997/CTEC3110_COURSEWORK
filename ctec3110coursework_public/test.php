<?php
$wsdl = "https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl";
$username = "19_Sebastian";
$password = "passXDword123";
$key = 1;



try
{
	$soap_client_handle = new SoapClient($wsdl);
	$soap_call_result = $soap_client_handle->peekMessages($username, $password, 25, "");
	for ($i=0; $i<25; $i++){
	$xml = $soap_call_result[$i];
	//$final = simplexml_load_string($xml);
	echo 'MESSAGE ' . $i . ' <br/>Source - ' . $final[0]->sourcemsisdn . 
	     '<br/>Dest - ' . $final[0]->destinationmsisdn . 
	     '<br/>Date - ' . $final[0]->receivedtime . 
	     '<br/>Type - ' . $final[0]->bearer . 
	     '<br/>Message: '. $final[0]->message .'<br/><br/>'; 

	}

	$xml = $soap_call_result[0];
	$final = simplexml_load_string($xml);
	$themessage = $final[0]->message;
	echo $themessage .'<br/>';

	var_dump($soap_call_result);

}
catch (SoapFault $exception)
{
    trigger_error($exception);
}


