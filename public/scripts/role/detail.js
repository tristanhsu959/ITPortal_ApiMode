/* Role Create JS */

$(function(){
	$('.btn-save').click(function(){
		submitForm();
	});
	
	$('#group').change(function(){
		let groupId = '.g-' + $(this).val();
		
		$('.role-permission').find('.admin .switch input').prop('disabled', true);
		$('.role-permission').find('.admin').hide();
		$('.role-permission').find(groupId).find('.switch input').prop('disabled', false);
		$('.role-permission').find(groupId).show();
	}).trigger('change');
});

function submitForm()
{
	//沒有設定權限也可以Submit
	if (validateForm(['#name', '#group']))
	{
		$('#loading').addClass('active');
		$('#roleForm').submit();
	}
	else
		showAlertDialog('身份名稱及權限群組為必填');
}