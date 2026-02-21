/* Role Create JS */

$(function(){
	$('.btn-save').click(function(e){
		e.preventDefault();
		submitForm();
	});
	
	$('.btn-generate-pwd').click(function(e){
		e.preventDefault();
		generatePassword();
	});
	
	$('.btn-view-pwd').click(function(e){
		e.preventDefault();
		visibilePassword();
	});
});

function submitForm()
{
	if (validateForm(['#adAccount', 'input[name=role]:checked']))
	{
		if ($('#password').val() != '')
		{
			const pattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/;
			
			if (pattern.test($('#password').val())) 
			{
				$('#loading').addClass('active');
				$('#userForm').submit();
			}
			else
				showAlertDialog('系統驗證密碼格式不符');
		}
		else
		{
			$('#loading').addClass('active');
			$('#userForm').submit();
		}
	}
	else
		showAlertDialog('[AD帳號][身份]為必填');
}

async function generatePassword()
{
	try 
	{
		const response = await axios.get('/password/generate');
		$('#password').val(response.data); 
		
		if (! $('.btn-view-pwd').hasClass('active'))
			$('.btn-view-pwd').trigger('click');
	} 
	catch (error) 
	{
		console.error('發生錯誤：', error);
	}
}

function visibilePassword()
{
	if ($('.btn-view-pwd').hasClass('active'))
	{
		$('.btn-view-pwd').removeClass('active');
		$('#password').prop('type', 'password'); 
	}
	else
	{
		$('.btn-view-pwd').addClass('active');
		$('#password').prop('type', 'text'); 
	}
}
