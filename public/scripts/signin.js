/* Login JS */

$(function(){
	$('#btnSignin').click(function() {
		if (validateForm(['#account', '#password'], true))
			$('#signinForm').submit();
		else
			return false;
	});
	
	$('#account, #password').on('keypress', function(e) {
		if (e.which == 13) {
			e.preventDefault(); 
			$('#btnSignin').trigger('click');
		}
	});
	
	//reset event in app.js
});