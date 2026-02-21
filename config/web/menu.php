<?php

use App\Enums\Permission;
use App\Enums\RoleGroup;

return [
	
	#由這裏控制順序/enabled/disabled
	'enabled' => [
		'user',
		'role',
	],
	
	#Function
	'available' => [
		'user' => [
			'name' 		=> '帳號管理',
			'url' 		=> 'user',
			'style'		=> ['icon' => 'account_circle', 'width' => 'w1', 'group' => 'admin g-'.RoleGroup::ADMIN->value],
			/* 'permissions'=> [
				Permission::READ, Permission::CREATE, Permission::UPDATE, Permission::DELETE, 
			], */
		],
		'role' => [
			'name' 		=> '身份管理',
			'url' 		=> 'role',
			'style'		=> ['icon' => 'group', 'width' => 'w1', 'group' => 'admin g-'.RoleGroup::ADMIN->value],
			/* 'permissions'=> [
				Permission::READ, Permission::CREATE, Permission::UPDATE, Permission::DELETE, 
			], */
		],
	],
];
