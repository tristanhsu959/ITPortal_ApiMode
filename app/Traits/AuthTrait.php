<?php

namespace App\Traits;

use App\Models\CurrentUser;
use App\Traits\MenuTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/* 登入相關流程處理 */
trait AuthTrait
{
	use MenuTrait;
	
	const SESS_AUTH_USER = 'Sess:AuthUser';
	const SESS_AUTH_MENU = 'Sess:AuthMenu';
	
	
	/* 清除登入資訊|Menu
	 * @params: 
	 * @return: boolean
	 */
	public function removeCurrentUser()
	{
		session()->forget(self::SESS_AUTH_USER);
		session()->forget(self::SESS_AUTH_MENU);
		
		return TRUE;
	}
	
	/* 儲存登入資訊
	 * @params: array
	 * @params: array
	 * @return: boolean
	 */
	public function saveCurrentUser($adInfo, $userInfo)
	{
		$currentUser = new CurrentUser($adInfo, $userInfo);
		session()->put(self::SESS_AUTH_USER, $currentUser);
		
		return TRUE;
	}
	
	/* Get current user
	 * @params: 
	 * @return: array
	 */
	public function getCurrentUser()
	{
		if (session()->missing(self::SESS_AUTH_USER))
			return FALSE;
		
		return session()->get(self::SESS_AUTH_USER);
	}
	
	/* 取已授權的Menu (登入驗後)
	 * @params: 
	 * @return: array
	 */
	public function getAuthMenu()
	{
		$authMenu = [];
		
		#1.若有取過, 直接取Session
		if (session()->has(self::SESS_AUTH_MENU))
			return session()->get(self::SESS_AUTH_MENU);
		
		#2.取目前登入使用者
		$currentUser = $this->getCurrentUser();
		
		if ($currentUser === FALSE)
			return $authMenu;
		
		#3.取功能選單設定檔
		$menuConfig = $this->getMenu();
		
		#4.驗證使用者有權限的選單, 只要驗證到功能即可
		$permissions = $currentUser->getPermissions();
		
		$authMenu =  Arr::only($menuConfig, $permissions);
		session()->put(self::SESS_AUTH_MENU, $authMenu);
		
		return $authMenu;
	}
}