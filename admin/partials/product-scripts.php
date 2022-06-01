<?php

foreach ($products as $child)
{    

    ?>
	<div class="card product shadow m-2 p-0 <?php echo $child->CATEGORIA ?>" style="width:350px; position:relative">
		<div style="position:absolute; top:20px;right:20px">
			<input class="products shadow-sm" style="width:30px; height:30px" value='<?php echo json_encode($child) ?>' type="checkbox"></input>
		</div>
		<img style="margin:0 auto;width:100%;" class="card-img-top" src="<?php echo $child->IMAGENES->{'ID-0'}->nombre;?>" alt="Card image cap">

		<div class="card-body">
			<h6 class="card-title"><?php echo $child->NOMBRE ?></h6>
			<p class="card-text">
				<small>SKU: <?php echo $child->EAN ?></small><br>
				<small>Item Price:<b class="text-success"> $<?php echo $child->PRECIO ?></b></small><br>
				<small>Category:<b class="text-success"> <?php echo $child->CATEGORIA ?></b></small>
			</p>
		</div>
	</div>
<?php     
	
	}

?>



