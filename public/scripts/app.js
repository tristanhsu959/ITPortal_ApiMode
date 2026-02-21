/* Common JS */

$(function(){
	//擋右鍵
	$(document).on('contextmenu', function(e){
		e.preventDefault();
	});
	
	hasToast();
	initializeMenu();
	initializeEvents();
});

function test() {alert(123);};
/*** Initialize ***/
function initializeMenu()
{
	/* Menu */
	$('.menu .menu-group').each(function($item, $key){
		$(this).find('a.list-title').removeClass('active');
		
		$(this).find('.list-group li a').each(function($item, $key){
			if ($(this).hasClass('active'))
			{
				$(this).closest('.collapse').collapse('show');
				$(this).closest('.menu-group').find('a.list-title').addClass('active');
			}
		});
	});
	
	$('.menu .menu-group .list-group-item a').click(function(){
		$('#loading').addClass('active');
	});
}

function initializeEvents()
{
	$('#btnReset').click(function(){
		$(this).closest('form').get(0).reset();
	});
	
	/* Remove invalid style */
	$('.field input').on('keypress', function(event){
		$(this).closest('.field').removeClass('invalid');
	});
	
	/* var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	}) */
}
/*** Initialize End ***/

/* valid or invalid */
function validateForm(fields, invalidStyle)
{
	//el: id/class/ or ....
	if ($.isArray(fields))
	{
		let result = true;
		
		$.each(fields, function(key, el){
			result = result & validateInput(el, invalidStyle);
		});
		
		return Boolean(result);
	}
	else
		return validateInput(fields, invalidStyle);
}

function validateInput(el, invalidStyle)
{
	invalidStyle = invalidStyle || false;
	
	if (invalidStyle)
		$(el).closest('.field').removeClass('invalid');
	
	if ($(el).val() == '' || typeof $(el).val() == 'undefined')
	{
		if (invalidStyle)
			$(el).closest('.field').addClass('invalid');
		return false;
	}
	else
		return true;
}

//Called by backend
function hasToast()
{
	if ($.trim($('#msg .message').html()) != '')
		showToast($('#msg .message').html());
}

//Called by js
function showToast(msg)
{
	msg = msg || '';
	
	if (msg != '')
	{
		$('#msg .message').html(msg);
		ui('#msg', 3000);
		
		$('#msg .btn-close').off('click').click(function(){
			$('#msg').removeClass('active');
		});
	}
}

/* Dialog */
function showAlertDialog(desc)
{
	$('#alertModal .message').text(desc);
	ui('#alertModal');
}

function showConfirmDialog(desc, callback)
{
	$('#confirmModal .message').text(desc);
	/* 須用on event模式 */
	$('#confirmModal .btn-confirm').off('click').on('click', function(){
		callback();
		ui('#confirmModal');
	});
	
	ui('#confirmModal');
}

