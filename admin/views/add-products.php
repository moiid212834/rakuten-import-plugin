<?php include 'header.php'; ?>
<?php include_once plugin_dir_path( __FILE__ ) .'../partials/pagination.php'; ?>
<?php include_once plugin_dir_path( __FILE__ ) .'../partials/get-product-ids.php'; ?>
<?php include_once plugin_dir_path( __FILE__ ) .'../partials/get-products-by-catrgory.php'; ?>
<div class="bg-white border p-4 mr-4 mt-2">
	<h1 class=" mt-3">Import Products</h1>
	
	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link <?php if (!isset($_GET['tabindex'])) echo 'active' ?>" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Options</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?php if (isset($_GET['tabindex']) && $_GET['tabindex']=="1" ) echo 'active' ?>" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Product Importer</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?php if (isset($_GET['tabindex']) && $_GET['tabindex']=="2") echo 'active' ?>" id="profile-tab" data-toggle="tab" href="#importall" role="tab" aria-controls="importall" aria-selected="false">Import All</a>
		</li>
	</ul>
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade <?php if(!isset($_GET['tabindex'])) echo 'show active' ?> py-3" id="home" role="tabpanel" aria-labelledby="home-tab">
			<form id="optionsform">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>API Username</label>
							<input name="ru" class="form-control" type="text" id="ru" value="<?php echo $options->ru?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>API Password</label>
							<input name="rp" class="form-control" type="text" id="rp" value="<?php echo $options->rp ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>API Cliente ID</label>
							<input name="rtrc" class="form-control" type="text" id="rtrc" value="<?php echo $options->rtrc?>">
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Save</button>
			</form>
		</div>
		<div class="tab-pane <?php if (isset($_GET['tabindex']) && $_GET['tabindex']=="1") echo 'show active' ?> fade py-3" id="profile" role="tabpanel" aria-labelledby="profile-tab">
			<div class="d-flex justify-content-between">
				<div class="mr-4 rounded p-4 w-100">	
					<h2>Search</h2>
					
					<form id="searchform" class="p-3 border rounded">
						<div class="form-group">
							<label>Categories</label>
							<select id="cats" name="cat">
								<option value="">All</option>
								<?php include plugin_dir_path( __FILE__ ) .'../partials/categories-script.php'; ?>
							</select>
						</div>
						<input type="hidden" name="page" value="importer">
						<label for="s" class="mr-2 form-inline">
							<strong>Products to Display</strong>
							<label class="mx-3">
								<input  type="hidden" name="from" id="from" value="<?php echo $from ?>" class="mt-1 form-control">
								
							</label>
							<?php if (!isset ($_GET['cat']) || !$_GET['cat']!="" ): ?>
							<label class="mx-1">
								<select name="to" id="to" class="form-control">
									<option value="10" <?php if ($to==10) echo "selected"; ?> class="form-control">10</option>
									<option value="20" <?php if ($to==20) echo "selected"; ?> class="form-control">20</option>
									<option value="30" <?php if ($to==30) echo "selected"; ?> class="form-control">30</option>
									<option value="40" <?php if ($to==40) echo "selected"; ?> class="form-control">40</option>
									
								</select>
							</label>
							<?php 	else: ?>
							Displaying products: <?php 	echo count($products) ?>
							<?php 	endif ?>
							<input type="hidden" name="tabindex" value="1">
							
						</label>
						<div>
							<input type="submit" class="btn btn-outline-primary px-5" name="submit" value="Go">
						</div>
					</form>
					<div class="form-group mt-4 d-flex flex-row justify-content-start">
						
						<label for="s" class="mr-2">
							Enter Keyword for Product Search
							<input  type="text" name="keyword" id="s" class="mt-1 form-control">
							<small>Would display products with exact matches.</small>
						</label>
					</div>
					<div class="d-flex flex-row justify-content-between mr-4 mt-3 bg-white rounded p-4 shadow border" style="position: sticky !important; top:45px; z-index: 999">
						<div class="term"><h3 class="search">Products</h3></div>
						<div class="t">
							<label class="mt-2 mr-3">Select All <input type="checkbox" style="width:30px; height:30px" name="all" id="selall"></label>
							<button id="importbtn" type="button" class="btn btn-primary px-5 disabled m-2" disabled="">Import & Publish</button>
							<button id="draftbtn" type="button" class="btn btn-primary px-5 disabled m-2" disabled="">Import & Draft</button>
						</div>
					</div>
					<div id="products-container" class="mr-4 mt-4 d-flex flex-row justify-content-start flex-wrap">
						
						<?php include plugin_dir_path( __FILE__ ) .'../partials/product-scripts.php'; ?>
					</div>
				</div>
			</div>
			<div class="w-100 text-center d-flex justify-content-center ">
				
				<?php if ( $previd >= 0 ): ?>
				<div>
					<button class="btn btn-outline-primary mr-1" value="<?php echo $previd ?>" onclick="nextpage($(this))">Previous Page</button>
				</div>
				<?php endif ?>
				<?php if (!isset ($_GET['cat']) || !$_GET['cat']!="" ): ?>
				<div>
					<form id="pagination" >
						<input id="page" class="d-inline form-control mx-2" style="max-width: 70px;" type="number" name="page" value="<?php echo $pagenumber+1 ?>">
					</form>
				</div>
				<?php endif ?>
				
				<div>
					<button class="btn btn-outline-primary ml-1 " value="<?php echo $nextid ?>" onclick="nextpage($(this))">Next Page</button>
				</div>
			</div>
		</div>
		<div class="tab-pane <?php if (isset($_GET['tabindex']) && $_GET['tabindex']=="2") echo 'show active' ?> fade py-3" id="importall" role="tabpanel" aria-labelledby="importall-tab">
			<?php include plugin_dir_path( __FILE__ ) .'../partials/import-all.php'; ?>
		</div>
	</div>
</div>
<div class="loadwrap" style="position: fixed; height: 100%; width: 100%; left:0; top:0; z-index: -80000" >
	<div class="load d-none justify-content-center align-items-center h-100 w-100">
		<div class="loader">
			<span class="sr-only">Loading...</span>
		</div>
	</div>
</div>
</div>
<?php include 'footer.php'; ?>
<script type="text/javascript">
	$('#optionsform').submit(function(event) {
		/* Act on the event */
		event.preventDefault();
			
		$.ajax({
			type: 'get',
			data: $(this).serialize(),
		})
		.done(function(response) {
			location.reload(true);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});
	function nextpage($this){
		var nextid=parseInt($this.val());
		$('#from').val(nextid);
		$('input[type="submit"]').click();
	}
	$('#pagination').submit(function(event) {
		/* Act on the event */
		event.preventDefault();
		var pagenum=parseInt($('#page').val());
		var qty=parseInt($('#to').val());
		var nextid=pagenum*qty;
		$('#from').val(nextid);
		$('input[type="submit"]').click();
	});
	$('#cats').change(function(event) {
		/* Act on the event */
		$('#from').val('0');
	});
</script>