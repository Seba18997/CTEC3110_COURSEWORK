<?php
$wsdl = "https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl";
$username = "19_Sebastian";
$password = "passXDword123";
$key = 1;



try
{
	$soap_client_handle = new SoapClient($wsdl);
	$soap_call_result = $soap_client_handle->peekMessages($username, $password, 1, "");
	$xml = htmlspecialchars(reset($soap_call_result), ENT_NOQUOTES);
	echo $xml;
	$final = simplexml_load_string($xml);
	echo $final[0]->sourcemsisdn; 

	

}
catch (SoapFault $exception)
{
    trigger_error($exception);
}


