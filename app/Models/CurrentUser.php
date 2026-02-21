<?php

namespace App\Models;

use App\Enums\RoleGroup;

class CurrentUser
{
	private $_data = [];
	
	public function __construct($adInfo, $userInfo)
	{
		$info = array_merge($adInfo, $userInfo);
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