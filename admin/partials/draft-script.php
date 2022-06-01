<script type="text/javascript">
	$('#draftbtn').click(function(event) {
		$('.loadwrap').css({
			'z-index': '999999',
			background: 'rgba(255,255,255,0.6)'
		});
		$('.load').addClass('d-flex').removeClass('d-none');
		$.ajax({
			type: 'post',
			url:'https://importer-woocommerce.ga/wp-admin/admin.php?page=importer',
			data: {products:JSON.stringify(selecteditems),draft:'true'},
		})
		.done(function(response) {
			toastr["success"]("Products Successfully Added", "Woocommerce Importer")
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
			console.log(error);

		})
		.fail(function(error) {
			toastr["error"]("There was an error uploading the product, please check for plugin or theme conflicts or contact your developer.", "Woocommerce Importer")
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
			}
		})
		.always(function() {
			$('.loadwrap').css({
				'z-index': '-999999',
				background: 'rgba(255,255,255,0.6)'
			});
			$('.load').removeClass('d-flex').addClass('d-none');
		});
	});
</script>		