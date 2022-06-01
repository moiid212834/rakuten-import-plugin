	var gtoken="";
	var merchants_imported=false;
	function fetch_products(data){
		var username=$('#ru').val();
		var password=$('#rp').val();
		var sid=$('#ri').val();
		var request=$('#rtrc').val();
		$.ajax({
			url: 'https://api.rakutenmarketing.com/token',
			type: 'post',
			data: {
				username:username,
				password:password,
				grant_type:"password",
				scope:sid,
			},
			headers:{
				Authorization: request,
			}
		})
		.done(function(response) {
			gtoken=response.access_token;
			get_products(response.access_token,data);
			if (!merchants_imported){
				get_merchants(gtoken);
				merchants_imported=true;
			}
		})
		.fail(function(error) {
			toastr["error"]("There is an error in your credentials, please recheck the credentials from Rakuten.", "Woocommerce Importer")
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
			$('.loadwrap').css({
				'z-index': '-999999',
				background: 'rgba(255,255,255,0.6)'
			});
			$('.load').removeClass('d-flex').addClass('d-none');
		})


	}

	function get_merchants(token){
		console.log("Bearer "+token);
		$.ajax({
			url: 'https://api.rakutenmarketing.com/advertisersearch/1.0',
			headers:{
				"Authorization":"Bearer "+token,
			}
		})
		.done(function(response) {
			merchants=xmlToJson(response);
			merchants=merchants.result.split("\n");
			for (var i =3 ; i <= merchants.length - 1; i=i+2) {
				if (merchants[i]!='') {
					$('#merchants').append('<option value='+merchants[i]+'>'+(merchants[i+1]==""?'mid:'+merchants[i]:merchants[i+1])+'</option>')
				};
			};
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}

	function get_products(token,data){
		const settings = {
			"async": true,
			"crossDomain": true,
			"url": "https://api.rakutenmarketing.com/productsearch/1.0",
			"method": "GET",
			"headers": {
				"Authorization":"Bearer "+token,
			},
			"data":data,
		};
		console.log(settings);

		$.ajax(settings).done(function (response) {
			$('.loadwrap').css({
				'z-index': '-999999',
				background: 'rgba(255,255,255,0.6)'
			});
			$('.load').removeClass('d-flex').addClass('d-none');
			var object= xmlToJson(response);
			console.log(object);
			var totalpages=object.result.TotalPages;
			totalpages=totalpages<=0?1:totalpages;
			$('#totalp').html(totalpages);
			$('#pagenum').attr('max', totalpages);

			var items=object.result.item;
			if (items) {
				for (var i = 0; i < items.length; i++) {
					$('#products-container').append(build_item(items[i]));
				};
			}else{
				$('#products-container').append('<h3 class="py-5">No Products Available</h3>');
			};
			
		
		}).fail(function(error){
		
			console.log(error);
			toastr["error"]("There was an error loading the product, please check for plugin or theme conflicts or contact your developer.", "Woocommerce Importer")
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
				
		}).always(function(){
			$('.loadwrap').css({
				'z-index': '-999999',
				background: 'rgba(255,255,255,0.6)'
			});
			$('.load').removeClass('d-flex').addClass('d-none');
		});

		
	}
