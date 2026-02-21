<?php

namespace App\Enums;

enum Functions : string
{
	case USER	= 'user';
	case ROLE 	= 'role';
	
	public function label() : string
    {
        return match ($this) 
		{
			self::USER		=> '帳號管理',
			self::ROLE 		=> '身份管理',
        };
    }
}
