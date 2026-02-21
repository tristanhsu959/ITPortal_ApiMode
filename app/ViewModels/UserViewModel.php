<?php

namespace App\ViewModels;

use App\Services\OptionService;
use App\ViewModels\Attributes\attrStatus;
use App\ViewModels\Attributes\attrActionBar;
use App\ViewModels\Attributes\attrAllowAction;
use App\Enums\FormAction;
use App\Enums\RoleGroup;
use App\Enums\Functions;
use App\Enums\Status;
use Illuminate\Support\Str;

class UserViewModel
{
	use attrStatus, attrActionBar, attrAllowAction;
	
	private $_title 	= '帳號管理';
	private $_function	= Functions::USER->value;
	private $_backRoute	= 'user'; #set by route name
	private $_data 		= [];
	
	public function __construct(protected OptionService $_service)
	{
		#initialize
		$this->_data['action'] 	= FormAction::LIST; #default
		$this->success();
		
		#Form Data
		$this->_data['user'] 	= NULL; #DB data
		$this->_data['list'] 	= []; #DB data
		$this->_data['search']	= [];
		$this->_data['option']	= [];
		$this->_data['hasPassword'] = FALSE;
	}
	
	public function __set($name, $value)
    {
		$this->_data[$name] = $value;
    }
	
	public function __get(string $name)
    {
		return data_get($this->_data, $name, '');
	}
	
	/* 須有isset, 否則empty()會判別錯誤 */
	public function __isset($name)
    {
		return array_key_exists($name, $this->_data);
	}
	
	public function breadcrumb()
	{
		return $this->_defaultBreadcrumb();
	}
	
	/* Form params, options */
	public function initialize($action = FormAction::LIST)
	{
		$this->_data['action'] = $action;
		$this->_initializeOptions();
		
		if ($action == FormAction::LIST)
			$this->keepSearchData(); #for init
		else
			$this->keepFormData(); #for init
	}
	
	/* Form所屬的參數選項
	 * @params:  
	 * @return: void
	 */
	private function _initializeOptions()
	{
		if ($this->_data['action'] == FormAction::LIST)
			$this->_data['option']['roleList']	= $this->_service->getRoleOptions();
		else
			$this->_data['option']['roleList']	= $this->_service->getEnableRoleOptions();
	}
	
	/* ====== List ====== */
	/* Keep search data of form
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: string
	 */
	public function keepSearchData($ad = NULL, $name = NULL, $roleId = 0)
    {
		data_set($this->_data, 'search.ad', $ad);
		data_set($this->_data, 'search.name', $name);
		data_set($this->_data, 'search.roleId', $roleId);
	}
	
	/* ====== Permission ====== */
	
	/* 判別列表的使用者是否可編輯(除登入者權限外)
	 * @params: int : 欲刪除的user id
	 * @params: int : 欲刪除的user role group
	 * @return: boolean
	 */
	public function canEditThisUser($roleGroup)
	{
		#Supervisor為預設, 不可編輯
		return ! (RoleGroup::SUPERVISOR->value == $roleGroup);
	}
	
	/* 判別列表的使用者是否可刪除(除登入者權限外)
	 * @params: int : 欲刪除的user id
	 * @params: int : 欲刪除的user role group
	 * @return: boolean
	 */
	public function canDeleteThisUser($userId, $roleGroup)
	{
		#當前使用者(即自己)/Supervisor不可刪
		return ! ($this->isCurrentUser($userId) OR (RoleGroup::SUPERVISOR->value == $roleGroup));
	}
	/* ====== List End ====== */
	
	/* ====== Form Data ====== */
	/* Keep user form data
	 * @params: int
	 * @params: string
	 * @params: int
	 * @return: void
	 */
	public function keepFormData($id = 0, $adAccount = NULL, $roleId = 0, $isActive = TRUE, $updateAt = NULL)
    {
		data_set($this->_data, 'user.id', $id);
		data_set($this->_data, 'user.ad', $adAccount);
		data_set($this->_data, 'user.roleId', $roleId);
		data_set($this->_data, 'user.isActive', intval($isActive));
		data_set($this->_data, 'user.updateAt', $updateAt);
	}
	
	/* Form submit action
	 * @params: 
	 * @return: string
	 */
	public function getFormAction() : string
    {
		return match($this->action)
		{
			FormAction::CREATE => route('user.create.post'),
			FormAction::UPDATE => route('user.update.post'),
		};
	}
	
	public function updatePasswordStatus($password)
    {
		$this->_data['hasPassword'] = empty($password) ? FALSE : TRUE;
	}
	
	public function isUpdate()
    {
		return ($this->_data['action'] == FormAction::UPDATE);
	}
	
	public function hasPassword()
    {
		return ($this->isUpdate() and $this->_data['hasPassword'] === TRUE);
	}
	
	public function getActiveStyle($isActive)
    {
		return (intval($isActive) == Status::ACTIVE->value) ? 'active' : 'inactive';
	}
}