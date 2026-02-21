/* JS */

$(function(){
	$('.btn-delete').click(function(e){
		e.preventDefault();
		let action = $(this).attr('href');
		
		let callback = function(){
			$('#userForm').attr('action', action).submit();
		};
		
		showConfirmDialog('是否確認刪除?', callback);
	});
	
	$('.btn-search').click(function(e){
		$('#loading').addClass('active');
		$('#searchForm').submit();
		/* if (validateForm('#searchAd') || validateForm('#searchName') || validateForm('#searchArea'))
			$('#searchForm').submit();
		else
			showAlertDialog('至少須輸入一個條件'); */
	});
	
	$('.btn-search-reset').click(function(e) {
		//因有記憶前值, 故不能call reset()
		$('#searchForm').find('.field input').val('');
        $('#searchForm').find('.field select').prop('selectedIndex', 0);
		//$(this).closest('form').get(0).reset();
	});
});