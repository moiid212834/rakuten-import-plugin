<div class="container-fluid">
	<div class="mr-4 rounded p-4 w-100">
		<div class="row">
			<div class="col-md-6">
				<h5 class="mb-3">Import All products</h5>

				<div>
					<label for='maxprod'> Maximum Products</label>
					<input type="number" class="form-control" name="maxprod" id="maxprod" value="6589" min="0" max="6589">
					<label class="mt-2"><input class=""  style="width:30px; height:30px" type="checkbox" id="draftallimp"> Draft the imported products</label>
					<small>Total Number of Products: <b>6589</b></small>
				</div>
				<div class="mt-4">Importing all products might take upto 1 hour(s)</div>
				<div class="mt-4">
					<button class="my-2 btn btn-outline-primary" id="importallbtn">Start Importing all products</button>
				</div>
			</div>
			<div class="col-md-6 border-left">
				<h5 class="mb-3">Import all products in a category</h5>
				<div>This process might take upto 10 minutes</div>
				<div class="mt-4">
					Choose category
					<select id="importallcatsel">
						<?php include 'categories-script.php' ?>
					</select>
				</div>
				<div>
					<label class="mt-2"><input style="width:30px; height:30px" class="mt-1" type="checkbox" id="draftcatimp"> Draft the imported products</label>
					<button class="my-2 btn btn-outline-primary" id="importcat">Start Importing all products from this category</button>
				</div>
			</div>
		</div>
	</div>
</div>
<button class="btn btn-primary d-none" id="modal-activate" data-toggle="modal" data-target="#modal-1">Large modal</button>
<div class="modal fade" id="modal-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header  d-flex justify-content-center">
				<h4 class="modal-title">Bulk Import</h4>
				<button type="button" class="close d-none" data-dismiss="modal" aria-label="Close">
				<span class="sr-only">Close</span>
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="h3 text-center my-4">Your products are being imported!</div>
				<div class="loadwrap d-block" style="height: 100%; width: 100%; left:0; top:0; display: block!important" >
					<div class="load d-flex justify-content-center align-items-center h-100 w-100" style="display: flex!important">
						<div class="loader">
							<span class="sr-only">Loading...</span>
						</div>
					</div>
				</div>
				<div class="text-center my-4">This process can take <div class="timing"> several minutes</div> <br> Please hold tight and <span class="text-danger font-weight-bold">Do not refresh the page!</span></div>
			</div>
			<div class="modal-footer d-none">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Continue in background</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
	$(function() {
		$('#maxprod').keydown(function(event) {
			/* Act on the event */
			var inval= parseInt(String.fromCharCode(event.keyCode));
			if(parseInt($(this).val()+inval)>=6590){ $(this).val(6589);event.preventDefault()};
			if(parseInt($(this).val())<=-1) {$(this).val(0);event.preventDefault();};
			console.log($(this).val(),parseInt($(this).val())>=6590,);
		});
		$(document).on('click', '#importallbtn', function(event) {
			event.preventDefault();
			$('#maxprod').val()<0?$('#maxprod').val(0):$('#maxprod').val();
			if( !confirm('Are you sure you want to continue with importing all products? The process will take multiple minutes!')) {
                return false;
            }
			$('.modal').modal('show');
			$('.timing').text('upto 1 hour(s)')
			/* Act on the event */
			console.log('importall');
			var draftem=0;
			if($('#draftallimp').is(':checked')){
				draftem=1;
			}; 
			console.log("draft"+draftem); 

			/* Act on the event */
			$.ajax({
				type: 'post',
				data: {
					'importall': 'true',
					'max':$('#maxprod').val(),
					'draftem':draftem,
					},
			})
			.done(function(response) {
				console.log(response);
				toastr["success"]("Products Successfully Added", "Woocommerce Importer")
				toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"positionClass": "toast-bottom-center",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "100000",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
				}
			})
			.fail(function(error) {
				console.log(error);
				toastr["error"]("There was an error uploading the products. Make sure you are not in incognito mode or please check for plugin or theme conflicts or contact your developer.", "Woocommerce Importer")
				toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"positionClass": "toast-top-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
				};
			})
			.always(function() {
				$('.modal').modal('hide');
				$('body').removeClass('modal-open');
				$('.modal-backdrop').remove();
				$('.timing').text('several minutes');

			});
		});
			

		$(document).on('click', '#importcat', function(event) {
			event.preventDefault();
			if( !confirm('Are you sure you want to continue with importing products from this category? The process will take multiple minutes!')) {
                return false;
            }
			$('.modal').modal('show');
			var cat=$('#importallcatsel').val();
			console.log(cat);
			var draftem=0;
			if($('#draftcatimp').is(':checked')){
				draftem=1;
			};
			console.log("draft"+draftem); 
			$.ajax({
				type: 'post',
				data: {
					'importall': 'true',
					'importcat': cat,
					'draftem':draftem,
					},
			})
			.done(function(response) {
				console.log(response);
				toastr["success"]("Products Successfully Added", "Woocommerce Importer")
				toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"positionClass": "toast-bottom-center",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "100000",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
				}
			})
			.fail(function(error) {
				console.log(error);
			})
			.always(function() {
				$('.modal').modal('hide');
				$('body').removeClass('modal-open');
				$('.modal-backdrop').remove();
			});
			
		});
	});
</script>