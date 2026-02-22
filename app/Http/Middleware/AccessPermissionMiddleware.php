<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\AuthTrait;

class AccessPermissionMiddleware
{
	use AuthTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		$currentUser = $this->getCurrentUser();
		
		if (empty($currentUser)) #fetch msg by : session('msg')
			return redirect()->route('login')->with('msg', '認證已過期，請重新登入');
		
		if (empty($currentUser->rolePermission) && ! $currentUser->isSupervisor())
			return redirect()->route('login')->with('msg', '使用者尚無系統授權');
		
        return $next($request);
    }
}
