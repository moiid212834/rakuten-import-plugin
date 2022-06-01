<?php
set_time_limit(0);
if (isset($_REQUEST['products'])) {
	# code...
	$jsonproducts=stripslashes($_REQUEST['products']);
	$products = json_decode($jsonproducts,true);
	if (isset($_REQUEST['publish'])) {
		$this->add_all_products($products);
	}else{
		$this->draft_all_products($products);

	}
	
	die;
}
else if (isset($_REQUEST['ru'])) {
	$jsonoptions= array('ru' =>$_REQUEST['ru'] ,'rp' =>$_REQUEST['rp'] ,'rtrc' =>$_REQUEST['rtrc'] ,'ri' =>$_REQUEST['ri'] );
	$options=(json_encode($jsonoptions));
	$this->update_options($options);
	die;
}
else if (isset($_REQUEST['importall'])) {
	include_once __DIR__.'/../partials/get-products.php';
	include_once __DIR__.'/../partials/get-product-ids.php';

	if (isset($_REQUEST['importcat']) || $_REQUEST['importcat']!="" ){
		//code
		$options=$this->get_options();
		$productids="Not needed";
		$products_in=getProducts($options, $productids, $_REQUEST['importcat']);
		$products=array();
		foreach ($products_in as $item)
		{    
    		foreach ($item->children() as $child) { 
				
					 array_push($products,json_encode($child));
					
    		}
    	}
		echo "draft".$_REQUEST['draftem'];
    	// var_dump($products);
    	if (isset($_REQUEST['draftem'])  && $_REQUEST['draftem']=='1') {
    		# code...
    		$this->draft_all_products($products);
    	}else{
    		$this->add_all_products($products);
    	}
    	
    	die;
	}else{
		//code
		
		$options=$this->get_options();
		$from=0;
		$once=intval($_REQUEST['max']);
		$products=array();
		$productids=getProductIds($from,$once,$options);
		$products_in=getProducts($options, $productids);
		foreach ($products_in as $item)
		{    
			foreach ($item->children() as $child) { 
				array_push($products,json_encode($child));		
			}
		}
		// for ($i=$once ; $i <= $max ; $i=$i+$once) { 
		// 	# code...
			
		// 	$from=$i;
		// }
		// var_dump($products);
		echo "draft".$_REQUEST['draftem'];
		if (isset($_REQUEST['draftem']) && $_REQUEST['draftem']=='1') {
    		# code...
    		$this->draft_all_products($products);
    	}else{
    		$this->add_all_products($products);
    	}
		
	}
	echo "import succesful";
	die;
}
?>
