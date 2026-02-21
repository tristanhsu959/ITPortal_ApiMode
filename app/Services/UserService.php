<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Libraries\ResponseLib;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Exception;
use Log;

class UserService
{
	public function __construct(protected UserRepository $_repository)
	{
	}
	
	/* 取帳號清單(Get ALL)
	 * @params: 
	 * @return: array
	 */
	public function getList()
	{
		try
		{
			$list = $this->_repository->getList();
			return ResponseLib::initialize($list)->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail($e->getMessage());
		}
	}
	
	/* 取帳號清單 By Query Conditions
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: array
	 */
	public function searchList($ad, $name, $roleId)
	{
		try
		{
			$list = $this->_repository->getList($ad, $name, $roleId);
			return ResponseLib::initialize($list)->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail($e->getMessage());
		}
	}
	
	/* Update:取User Data
	 * @params: int
	 * @return: array
	 */
	private function _isAccountExist($account, $exceptId = NULL)
	{
		$result = $this->_repository->getByAccount($account);
		
		#編輯時要判別是否同編輯帳號
		if ($result && $result['userId'] != $exceptId)
			return TRUE;
		
		return FALSE;
	}
	
	/* Create Account
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: array
	 */
	public function createUser($adAccount, $password, $roleId, $isActive)
	{
		try
		{
			#1.Check account
			if ($this->_isAccountExist($adAccount))
				throw new Exception('此帳號已存在');
			
			#2. Create data
			$password = Hash::make($password);
			$this->_repository->insert($adAccount, $password, $roleId, $isActive);
		
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail($e->getMessage());
		}
	}
	
	/* Update:取User Data
     * @params: int
     * @return: array
     */
    public function getUserById($id)
    {
        try
        {
            $result = $this->_repository->getById($id); 
            return ResponseLib::initialize($result)->success();
        }
        catch(Exception $e)
        {
            Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
            return ResponseLib::initialize()->fail($e->getMessage());
        }
    }
	
	/* Update User
	 * @params: int
	 * @params: string
	 * @params: int
	 * @return: array
	 */
	public function updateUser($userId, $adAccount, $password, $roleId, $isActive, $needRemovePwd)
	{
		try
		{
			if ($this->_isAccountExist($adAccount, $userId))
				throw new Exception('此帳號已存在');
			
			#移除已設定Password, 若有設定則直接覆蓋即可
			if (empty($password))
				$password = $needRemovePwd ? '' : FALSE; #False表不變更
			else
				$password = Hash::make($password);
			
			$this->_repository->update($userId, $adAccount, $password, $roleId, $isActive);
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail($e->getMessage());
		}
	}
	
	/* Remove User
	 * @params: int
	 * @return: array
	 */
	public function deleteUser($userId)
	{
		try
		{
			$this->_repository->remove($userId);
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail($e->getMessage());
		}
	}
}
