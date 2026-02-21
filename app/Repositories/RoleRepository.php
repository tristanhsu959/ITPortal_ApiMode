<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Exception;

class RoleRepository extends Repository
{
	
	public function __construct()
	{
		
	}
	/* Case-sensitive in ubuntu */
	/* Get role list from DB 
	 * @params: 
	 * @return: array
	 */
	public function getList()
	{
		try
		{
			$db = $this->connectItPortal('role');
				
			$result = $db
				->select('roleId', 'roleName', 'roleGroup', 'rolePermission', 'updateAt')
				->get()
				->toArray();
					
			return $result;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return FALSE;
		}
	}
	
	/* Create Role
	 * @params: string
	 * @params: string
	 * @params: json string
	 * @return: boolean
	 */
	public function insertRole($name, $group, $permission)
	{
		$roleData['roleName']		= $name;
		$roleData['roleGroup'] 		= $group;
		$roleData['rolePermission'] = $permission;
		$roleData['createAt'] 		= now()->format('Y-m-d H:i:s');
		$roleData['updateAt'] 		= $roleData['createAt'];
		
		$db = $this->connectItPortal('role');
		$id = $db->insertGetId($roleData);
		
		return TRUE;
	}
	
	/* Get Role Data
	 * @params: int
	 * @return: array
	 */
	public function getRoleById($id)
	{
		$db = $this->connectItPortal('role');
			
		$result = $db->select('roleId', 'roleName', 'roleGroup', 'rolePermission', 'updateAt')
					->where('roleId', '=', $id)
					->get()->first();
		
		return $result;
	}
	
	/* Update Role
	 * @params: int
	 * @params: string
	 * @params: int
	 * @params: json string
	 * @return: boolean
	 */
	public function updateRole($id, $name, $group, $permission)
	{
		#只能用facade
		
		$roleData['roleName']		= $name;
		$roleData['roleGroup'] 		= $group;
		$roleData['rolePermission']	= $permission;
		$roleData['updateAt'] 		= now()->format('Y-m-d H:i:s');
		
		$db = $this->connectItPortal('role');
		$db->where('roleId', '=', $id)->update($roleData);
		
		return TRUE;
	}
	
	/* Remove Role
	 * @params: int
	 * @return: boolean
	 */
	public function RemoveRole($roleId)
	{
		$db = $this->connectItPortal('role');
		$db->where('roleId', '=', $roleId)->delete();
		
		return TRUE;
	}
}
