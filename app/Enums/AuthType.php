<?php

namespace App\Enums;

enum AuthType : int
{
    case AD		= 1;
	case SYSTEM = 2;
	
	public function label() : string
    {
        return match ($this) 
		{
			self::AD		=> 'AD驗證',
			self::SYSTEM 	=> '系統驗證',
        };
    }
}
