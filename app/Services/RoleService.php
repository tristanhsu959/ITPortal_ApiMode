<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Traits\AuthorizationTrait;
#use App\Traits\RolePermissionTrait;
use App\Libraries\ResponseLib;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Exception;
use Log;

class RoleService
{
	public function __construct(protected RoleRepository $_repository)
	{
	}
	
	/* 取Role清單(Get ALL)
	 * @params: 
	 * @return: array
	 */
	public function getList()
	{
		try
		{
			$list = $this->_repository->getList();
			
			if ($list === FALSE)
				throw new Exception('讀取身份清單時發生錯誤');
			
			#處理Json type
			foreach($list as $key => $item)
			{
				$list[$key] = Arr::map($item, function ($value, string $key) {
					if ($key == 'rolePermission')
						return empty($value) ? [] : json_decode($value, TRUE);
					else
						return $value;
				});
			}
			
			return ResponseLib::initialize($list)->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail($e->getMessage());
		}
	}
	
	/* Create role
	 * @params: string
	 * @params: int
	 * @params: array
	 * @return: array
	 */
	public function createRole($name, $group, $permission)
	{
		try
		{
			$permission = json_encode($permission); 
			
			$this->_repository->insertRole($name, $group, $permission);
		
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('新增身份失敗');
		}
	}
	
	/* Get role by id
	 * @params: int
	 * @return: array
	 */
	public function getRoleById($id)
	{
		try
		{
			$result = $this->_repository->getRoleById($id);
			
			$result['rolePermission'] 	= empty($result['rolePermission']) ? [] : json_decode($result['rolePermission'], TRUE);
			
			return ResponseLib::initialize($result)->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('讀取身份設定資料發生錯誤');
		}
	}
	
	/* Update Role
	 * @params: int
	 * @params: string
	 * @params: int
	 * @params: array
	 * @return: array
	 */
	public function updateRole($id, $name, $group, $permission)
	{
		try
		{
			$permission = json_encode($permission); 
			$this->_repository->updateRole($id, $name, $group, $permission);
		
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('編輯身份失敗');
		}
	}
	
	/* Remove Role
	 * @params: int
	 * @return: array
	 */
	public function deleteRole($id)
	{
		try
		{
			$this->_repository->removeRole($id);
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('刪除身份失敗');
		}
	}
	
	#todo: 應該可廢棄
	/* CRUD Permission List
	 * @params: 
	 * @return: array
	 *
	 public function getOperationPermissions()
	 {
		try
		{
			return $this->getOperationPermissionsByFunction($this->_functionCode);
		}
		catch(Exception $e)
		{
			Log::channel('webSysLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return [];
		}
	 }
	 */
}
