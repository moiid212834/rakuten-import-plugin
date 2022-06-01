<?php 
include_once __DIR__.'/get-products.php';
include_once __DIR__.'/get-product-ids.php';

if (isset ($_GET['cat']) && $_GET['cat']!="" ) {
	$options=$this->get_options();
	$productids="Not needed";
	$products_in=getProducts($options, $productids, $_GET['cat']);
	$products=array();
	foreach ($products_in as $item)
	{    
		foreach ($item->children() as $child) { 
			
				 array_push($products,$child);
				
		}
	}
}else{
	$options=$this->get_options();
	$productids=getProductIds($from,$to,$options);
	$products_in=getProducts($options, $productids);
	$products=array();
	foreach ($products_in as $item)
	{    
		foreach ($item->children() as $child) { 
			array_push($products,$child);		
		}
	}
}
