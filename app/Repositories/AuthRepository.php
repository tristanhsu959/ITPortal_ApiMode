<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Exception;
use Log;

class AuthRepository extends Repository
{
	#Windows default is case-insensitive, Linex is case-sensitive
	#mysql是系統預設改不了或無效|檔案有分(table name)|Column & data似乎依編碼沒分
	public function __construct()
	{
		
	}
	
	/* Get user by account
	 * @params: string
	 * @return: array
	 */
	public function getUserByAccount($account)
	{
		try
		{
			$db = $this->connectItPortal('user');
				
			$result = $db->select('userId', 'userAd', 'userPassword', 'userRoleId', 'isActive')
						->addSelect('roleGroup', 'rolePermission')
						->addSelect('adCompany', 'adDepartment', 'adEmployeeId', 'adDisplayName', 'adMail')
						->join('role', 'roleId', '=', 'userRoleId')
						->leftJoin('user_ad_info', 'adUserId', '=', 'userId')
						->where('userAd', '=', $account)
						->get()->first();
			
			if ($result)
				$result['rolePermission'] = json_decode($result['rolePermission']);
			
			return $result;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			throw new Exception('讀取帳號資訊發生錯誤');
		}
	}
	
	/* Get permission of the user
	 * @params: int
	 * @params: array
	 * @return: boolean
	 */
	public function syncAdInfo($userId, $adInfo)
	{
		try
		{
			$data = [];
			
			#有資料才更新
			if (! empty(data_get($adInfo, 'company', '')))
				$data['adCompany'] = data_get($adInfo, 'company');
			
			if (! empty(data_get($adInfo, 'department', '')))
				$data['adDepartment'] = data_get($adInfo, 'department');
			
			if (! empty(data_get($adInfo, 'employeeId', '')))
				$data['adEmployeeId'] = data_get($adInfo, 'employeeId');
			
			if (! empty(data_get($adInfo, 'displayName', '')))
				$data['adDisplayName'] = data_get($adInfo, 'displayName');
			
			if (! empty(data_get($adInfo, 'mail', '')))
				$data['adMail'] = data_get($adInfo, 'mail');
			
			if (empty($data))
				return TRUE;
			
			$db = $this->connectItPortal('user_ad_info');
			$result = $db->updateOrInsert(['adUserId' => $userId], $data);
					
			return TRUE;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return FALSE;
		}
	}
	
	/* Set passwordd
	 * @params: int
	 * @params: string
	 * @return: boolean
	 */
	public function setPassword($userId, $hashPassword)
	{
		try
		{
			$db = $this->connectItPortal('user');
			
			$data['userPassword']	= $hashPassword;
			$data['updateAt'] 		= now()->format('Y-m-d H:i:s');
			
			$db->where('userId', '=', $userId)->update($data);			
			return TRUE;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return FALSE;
		}
	}
}
