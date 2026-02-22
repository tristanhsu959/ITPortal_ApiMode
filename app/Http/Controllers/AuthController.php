<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Libraries\ResponseLib;
use App\Enums\FormAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
	public function __construct(protected AuthService $_service)
	{
	}
	
	/* Login view
	 * @params: request
	 * @return: view
	 */
	public function index()
	{
		return view('login');
	}
	
	/* 登入驗證
	 * @params: request
	 * @return: view
	 */
	public function login(Request $request)
	{
		if (! $request->ajax())
			return response()->json(ResponseLib::initialize()->fail('Access Denied')->get());
		
		$account 	= $request->input('account');
		$password	= $request->input('password');
		$authType 	= $request->input('authType');
		
		$validator = Validator::make($request->all(), [
            'account' => 'required|max:20',
			'password' => 'required|max:20',
			'authType' => 'required',
        ]);
 
        if ($validator->fails())
			return response()->json(ResponseLib::initialize()->fail('登入失敗，帳號或密碼空白')->get());
		
		$response = $this->_service->login($account, $password, $authType);
		
		return response()->json($response->get());
	}
	
	/* Logout
	 * @params: request
	 * @return: view
	 */
	public function logout(Request $request)
	{
		$this->_service->logout();
		
		return view('login');
	}
	
	/* Setting password
	 * @params: request
	 * @return: view
	 */
	public function changePassword(Request $request)
	{
		if (! $request->ajax())
			return response()->json(ResponseLib::initialize()->fail('Access Denied')->get());
		
		$userId 		= $request->input('userId');
		$oldPassword 	= $request->input('oldPassword');
		$newPassword	= $request->input('newPassword');
		$confirmPassword= $request->input('confirmPassword');
		
		$validator = Validator::make($request->all(), [
			'userId' 		=> 'required',
            'oldPassword' 	=> 'required|max:20',
			'newPassword' 	=> 'required|max:20',
        ]);
 
        if ($validator->fails())
			return response()->json(ResponseLib::initialize()->fail('密碼設定失敗，參數驗證錯誤')->get());
		
		$response = $this->_service->setPassword($userId, $oldPassword, $newPassword);
		
		return response()->json($response->get());
	}
	
}