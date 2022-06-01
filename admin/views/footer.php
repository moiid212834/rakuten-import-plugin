
<!-- jQuery first, then Popper.js and Bootstrap JS. -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript" >
	
	$(document).ready(function() {
		
		$('.load').removeClass('d-flex').addClass('d-none');
		$('.modal .load').removeClass('d-none').addClass('d-flex');
		

		$("#s").keyup(function () {
			var txt = $('#s').val();
			$('.product').each(function(){
			   if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
			    	$(this).show();
			   }
			   else{
			   		$(this).hide();
			   }
			});
		});
	});

</script>
<?php include plugin_dir_path( __FILE__ ) .'../partials/build-item-script.php'; ?>
<?php include plugin_dir_path( __FILE__ ) .'../partials/draft-script.php'; ?>
<?php include plugin_dir_path( __FILE__ ) .'../partials/item-select-script.php'; ?>
<?php include plugin_dir_path( __FILE__ ) .'../partials/publish-script.php'; ?>
<?php include plugin_dir_path( __FILE__ ) .'../partials/xml-to-json-script.php'; ?>
