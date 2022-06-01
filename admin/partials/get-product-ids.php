<?php

function getProductIds($from,$to,$options){
error_reporting(E_ERROR | E_PARSE); 
    $xml = "<?xml version='1.0' encoding='utf-8'?>
    <inquiry>
        <userID>".$options->ru."</userID>
        <userPass>".$options->rp."</userPass>
        <method>getRef</method>
        <datos>
            <from>".$from."</from>
            <quantity>".$to."</quantity>
        </datos>
    </inquiry>";

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
        try{
            $xml = simplexml_load_string($result);

            // Loop through all of the properties.
            $property=$xml->referencias;
            // Reset the property tags array for this property.

            $productids = array();
            $i=1;
            
            foreach ( $property->children() as $children )
            {
            // If a tag was found, add it to the array.
            if ( ! empty($children[0]) )
                esc_html_e( $children );
              $productids[] = $children[0]->getName();
              $i++;
            }
        }catch(Throwable $t){
               ?>
                <p>They system took too long to respond to the query. Please try another Category or <a href="/wp-admin/admin.php?page=importer&from=0&to=20&tabindex=2&submit=Go">View All</a></p>
                <?
                exit;
            }
    return $productids;
}





