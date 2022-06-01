
<?php 
$curcat=$_GET['cat'];

$xml = "<?xml version='1.0' encoding='utf-8'?><inquiry><userID>".$options->ru."</userID><userPass>".$options->rp."</userPass><method>getFamilias</method></inquiry>";
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
?>
<?php 
foreach ($responseobj->xpath('//familias') as $item)
{    
    foreach ($item->children() as $child) { 
    	?>
			<option <?php echo ($child->cat==$curcat?"selected":"") ?> value="<?php echo $child->cat ?>"><?php echo $child->nombre ?></option>
			<?php 
				if ($child->children ) {
					foreach ($child->children->children() as $key => $value) {
						?>
						<option class="pl-3" value="<?php echo $value->cat ?>" <?php echo ($value->cat==$curcat?"selected":"") ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value->nombre ?></option>
						<?
						if ($value->children ) {
							foreach ($value->children->children() as $key => $value2) {
								?>
								<option class="pl-3" <?php echo ($value2->cat==$curcat?"selected":"") ?> value="<?php echo $value2->cat ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value2->nombre ?></option>
								<?
								if ($value2->children ) {
									foreach ($value2->children->children() as $key => $value3) {
									?>
										<option class="pl-3" <?php echo ($value3->cat==$curcat?"selected":"") ?> value="<?php echo $value3->cat ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value3->nombre ?></option>
									<?
								}
							}
						}
					}
				}
			}			     
		}
	}

?>



