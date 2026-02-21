<?php

namespace App\ViewModels;

use App\Services\OptionService;
use App\ViewModels\Attributes\attrStatus;
use App\ViewModels\Attributes\attrActionBar;
use App\ViewModels\Attributes\attrAllowAction;
use App\Traits\MenuTrait;
use App\Enums\FormAction;
use App\Enums\RoleGroup;
use App\Enums\Functions;

class RoleViewModel
{
	use attrStatus, attrActionBar, attrAllowAction, MenuTrait;
	
	private $_title 	= '身份管理';
	private $_function	= Functions::ROLE->value;
	private $_backRoute	= 'role'; #set by route name
	private $_data 		= [];
	
	public function __construct(protected OptionService $_service)
	{
		#initialize
		$this->_data['action'] 	= FormAction::LIST; #default
		$this->success();
		
		#Form Data
		$this->_data['role'] 	= NULL; #DB data
		$this->_data['list'] 	= []; #DB data
		$this->_data['search']	= [];
		$this->_data['option']	= [];
	}
	
	public function __set($name, $value)
    {
		$this->_data[$name] = $value;
    }
	
	public function __get($name)
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
	
	/* initialize
	 * @params: enum
	 * @return: void
	 */
	public function initialize($action = FormAction::LIST)
	{
		$this->_data['action'] = $action;
		$this->_initializeOptions();
		
		if ($action != FormAction::LIST)
			$this->keepFormData(); #for init
	}
	
	/* Form所屬的參數選項
	 * @params:  
	 * @return: void
	 */
	private function _initializeOptions()
	{
		if ($this->_data['action'] != FormAction::LIST)
		{
			$this->_data['option']['roleGroups'] 	= RoleGroup::getEnabledList();
			$this->_data['option']['functionList']	= $this->getMenu();
		}
	}
	
	/* ====== List ====== */
	/* ====== Permission ====== */
	
	/* 判別列表的身份是否可編輯
	 * @params: int : 欲刪除的 role id
	 * @params: int : 欲刪除的 role group
	 * @return: boolean
	 */
	public function canEditThisRole($roleGroup)
	{
		#Supervisor為預設, 不可編輯
		return ! (RoleGroup::SUPERVISOR->value == $roleGroup);
	}
	
	/* 判別列表的身份是否可刪除(除登入者權限外)
	 * @params: int : 欲刪除的 role id
	 * @params: int : 欲刪除的 role group
	 * @return: boolean
	 */
	public function canDeleteThisRole($roleGroup)
	{
		#Supervisor不可刪
		return ! (RoleGroup::SUPERVISOR->value == $roleGroup);
	}
	/* ====== List End ====== */
	
	/* ====== Form Data ====== */
	/* Keep user form data
	 * @params: int
	 * @params: string
	 * @params: int
	 * @params: array
	 * @params: array
	 * @return: void
	 */
	public function keepFormData($roldId = 0, $name = NULL, $group = 0, $permission = [], $updateAt = NULL)
    {
		#todo area
		data_set($this->_data, 'role.id', $roldId);
		data_set($this->_data, 'role.name', $name);
		data_set($this->_data, 'role.group', $group);
		data_set($this->_data, 'role.permission', $permission);
		data_set($this->_data, 'role.updateAt', $updateAt);
	}
	
	/* Form submit action
	 * @params: 
	 * @return: string
	 */
	public function getFormAction() : string
    {
		return match($this->action)
		{
			FormAction::CREATE => route('role.create.post'),
			FormAction::UPDATE => route('role.update.post'),
		};
	}
	
	public function isUpdate()
    {
		return ($this->_data['action'] == FormAction::UPDATE);
	}
}