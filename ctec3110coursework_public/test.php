<?php
$wsdl = "https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl";
$username = "19_Sebastian";
$password = "passXDword123";
$key = 1;



try
{
	$soap_client_handle = new SoapClient($wsdl);
	$soap_call_result = $soap_client_handle->peekMessages($username, $password, 1, "");
	var_dump($soap_call_result[0]);
	$debugx = var_export($soap_call_result, true);
	//$messages = new SimpleXMLElement($debugx);
	echo substr(htmlspecialchars($debugx), 19, -4);

	   

}
catch (SoapFault $exception)
{
    trigger_error($exception);
}


