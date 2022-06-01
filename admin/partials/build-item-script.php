<script type="text/javascript">
	function build_item(item){
		return(
			'<div class="card shadow m-2 p-0" style="width:350px; position:relative"><div style="position:absolute; top:20px;right:20px"><input class="products shadow-sm" style="width:30px; height:30px" value=\''+JSON.stringify(item)+'\' type="checkbox"></input></div><img style="margin:0 auto;width:100%;" class="card-img-top" src="'+item.imageurl+'" alt="Card image cap"><div class="card-body"><h6 class="card-title">'+item.productname+'</h6><p class="card-text"><small>SKU: '+item.sku+'</small><br><small>Item Price:<b class="text-success"> $'+item.price+'</b></small><br><small>Shop Name:<b class="text-success"> '+item.merchantname+'</b></small></small><br><small>Category:<b class="text-success"> '+item.category.primary+'</b></small></p><p class="card-text"><small class="text-muted"><a href="'+item.linkurl+'" target="_blank">See the Product on the Merchant Website></small></p></div></div>'
		)
	}
</script>