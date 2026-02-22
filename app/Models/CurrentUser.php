<?php

namespace App\Models;

use App\Enums\RoleGroup;

class CurrentUser
{
	private $_data = [];
	
	public function __construct($adInfo, $userInfo)
	{
		$info = $userInfo;
		
		$info['company'] 	= data_get($adInfo, 'company', $userInfo['adCompany']);
		$info['department']	= data_get($adInfo, 'department', $userInfo['adDepartment']);
		$info['employeeId'] = data_get($adInfo, 'employeeId', $userInfo['adEmployeeId']);
		$info['displayName']= data_get($adInfo, 'displayName', $userInfo['adDisplayName']);
		$info['mail'] 		= data_get($adInfo, 'mail', $userInfo['adMail']);
		
		data_forget($info, 'userPassword');
		data_forget($info, 'adCompany');
		data_forget($info, 'adDepartment');
		data_forget($info, 'adEmployeeId');
		data_forget($info, 'adDisplayName');
		data_forget($info, 'adMail');
		
		$this->_data = $info;
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
	
	/* 內建Supervisor (RoleGroup)
	 * @params:  
	 * @return: boolean
	 */
	public function isSupervisor()
	{
		$roleGroup = data_get($this->_data, 'roleGroup', 0);
		
		return ($roleGroup == RoleGroup::SUPERVISOR->value);
	}
	
	#改為只有判別功能,無CRUD
	/* Auth permission of function by current user
	 * @params: string
	 * @return: boolean
	 */
	public function hasPermissionTo($functionKey)
	{
		if ($this->isSupervisor())
			return TRUE;
		
		$permissions = data_get($this->_data, 'rolePermission', []);
		
		return in_array($functionKey, $permissions);
	}
	
	/* Get permission
	 * @params: 
	 * @return: boolean
	 */
	public function getPermissions()
	{
		if ($this->isSupervisor())
			return config('web.menu.enabled');
		
		return data_get($this->_data, 'rolePermission', []);
	}
	
	/* Show available name
	 * @params: 
	 * @return: boolean
	 */
	public function showAvailableName()
	{
		return empty($this->_data['displayName']) ? $this->_data['userAd'] : $this->_data['displayName'];
	}
}