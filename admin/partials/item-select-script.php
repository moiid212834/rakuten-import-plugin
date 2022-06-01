<script type="text/javascript">
	var selecteditems=[];
	$(document).on('click', '.products', function(event)  {
		selecteditems=[];
		$("input[type=checkbox]:checked").each(function(){
		selecteditems.push($(this).val());
		console.log(selecteditems);
		});
		if (selecteditems.length>0) {
			$('#importbtn').removeAttr('disabled').removeClass('disabled');
			$('#draftbtn').removeAttr('disabled').removeClass('disabled');
		}else{
			$('#importbtn').attr('disabled', 'disabled').addClass('disabled');
			$('#draftbtn').attr('disabled', 'disabled').addClass('disabled');
		};
	});
	$(function() {
		$('#selall').click(function(event) {
			/* Act on the event */
			$('.products').each(function(index, el) {
				this.click();
			});
		});	
	});
	
</script>