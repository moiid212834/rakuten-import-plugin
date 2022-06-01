<?php 
function getProducts($options,$productids, $cat=""){
	$xml = "<?xml version='1.0' encoding='utf-8'?><inquiry><userID>".$options->ru."</userID><userPass>".$options->rp."</userPass><method>getProductos</method><datos><idcliente>".$options->rtrc."</idcliente>";
	if ($cat=="") {
		$xml.="<productos>";
			foreach ($productids as $key => $value) {
			$xml.="<idproducto>".explode("-", $value)[1]."</idproducto>";
		}
		$xml.="</productos>";
	}else{
		$xml.="<categories>";
		$xml.="<idcat>".$cat."</idcat>";
		$xml.="</categories>";
	}	
	$xml.="</datos></inquiry>";
	

	$url = "http://ws.integrations.muchocartucho.es";

	//Initiate cURL
	$curl = curl_init($url);
	 
	//Set the Content-Type to text/xml.
	curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
	 
	//Set CURLOPT_POST to true to send a POST request.
	curl_setopt($curl, CURLOPT_POST, true);
	 
	//Attach the XML string to the body of our request.
	curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
	 
	//Tell cURL that we want the response to be returned as
	//a string instead of being dumped to the output.
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	 
	//Execute the POST request and send our XML.
	$result = curl_exec($curl);
	 
	//Do some basic error checking.
	if(curl_errno($curl)){
	    throw new Exception(curl_error($curl));
	}
	 
	//Close the cURL handle.
	curl_close($curl);
	 
	//Print out the response output.
	$responseobj=simplexml_load_string($result);


	return $responseobj->xpath('//productos');
}