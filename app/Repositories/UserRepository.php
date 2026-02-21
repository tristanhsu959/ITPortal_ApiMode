<?php

namespace App\Repositories;

use App\Enums\RoleGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;
use Exception;
use Log;

#因與service是1:1關係,故try catch寫在這,若是共用則要改到service
class UserRepository extends Repository
{
	
	public function __construct()
	{
		
	}
	
	/* Get user list by query conditions
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: array
	 */
	public function getList($ad = NULL, $name = NULL, $roleId = NULL)
	{
		try
		{
			$db = $this->connectItPortal('user as a');
				
			$db->select('a.userId', 'a.userAd', 'a.userRoleId', 'a.isActive', 'a.updateAt', 
						'b.roleName', 'b.roleGroup', 
						'c.adDepartment', 'c.adEmployeeId', 'c.adDisplayName', 'c.adMail')
				->leftJoin('role as b', 'b.roleId', '=', 'a.userRoleId')
				->leftJoin('user_ad_info as c', 'c.adUserId', '=', 'a.userId');
			
			#query conditions
			if (! is_null($ad))
				$db->where('a.userAd', 'like', "%{$ad}%");
			if (! is_null($name))
				$db->where('c.adDisplayName', 'like', "%{$name}%");
			if (! is_null($roleId))
				$db->where('a.userRoleId', '=', $roleId);
			
			$result = $db->get()->toArray(); #Collection array to assoc array
			
			return $result;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			throw new Exception('讀取帳號清單時發生錯誤');
		}
	}
	
	/* Get user by account
	 * @params: string
	 * @return: array
	 */
	public function getByAccount($account)
	{
		try
		{
			$db = $this->connectItPortal('user');
				
			$result = $db->select('userId', 'userAd')
						->where('userAd', '=', $account)
						->get()->first();
			
			return $result;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			throw new Exception('讀取帳號資料發生錯誤');
		}
	}
	
	/* Create Account
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: boolean
	 */
	public function insert($adAccount, $password, $roleId, $isActive)
	{
		try
		{
			$db = $this->connectItPortal('user');
			
			$data['userAd']			= $adAccount;
			$data['userPassword']	= $password;
			$data['userRoleId'] 	= $roleId;
			$data['isActive'] 		= $isActive;
			$data['createAt'] 		= now()->format('Y-m-d H:i:s');
			$data['updateAt'] 		= $data['createAt'];
				
			$db->insert($data);
			return TRUE;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			throw new Exception('帳號新增失敗');
		}
	}
	
	/* Get user by id
	 * @params: int
	 * @return: array
	 */
	public function getById($id)
	{
		try
		{
			$db = $this->connectItPortal('user');
				
			$result = $db->select('userId', 'userAd', 'userPassword', 'userRoleId', 'isActive', 'updateAt')
						->where('userId', '=', $id)
						->get()->first();
			
			return $result;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			throw new Exception('讀取帳號資料發生錯誤');
		}
	}
	
	/* Update user data by id
	 * @params: int
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: boolean
	 */
	public function update($userId, $adAccount, $password, $roleId, $isActive)
	{
		try
		{
			$db = $this->connectItPortal('user');
			
			$data['userAd']	= $adAccount;
			
			if ($password !== FALSE)
				$data['userPassword'] = $password;
			
			$data['userRoleId'] = $roleId;
			$data['isActive'] 	= $isActive;
			$data['updateAt'] 	= now()->format('Y-m-d H:i:s');
				
			$db->where('userId', '=', $userId)->update($data);
			return TRUE;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			throw new Exception('帳號編輯失敗');
		}
	}
	
	/* Remove user by id
	 * @params: int
	 * @return: boolean
	 */
	public function remove($userId)
	{
		try
		{
			$db = $this->connectItPortal('user');
			$db->where('userId', '=', $userId)->delete();

			return TRUE;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			throw new Exception('帳號刪除失敗');
		}
	}
}
