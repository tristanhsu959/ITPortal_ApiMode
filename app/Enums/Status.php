<?php

namespace App\Enums;

enum Status : int
{
    case ACTIVE		= 1;
	case INACTIVE 	= 0;
	
	public function label() : string
    {
        return match ($this) 
		{
			self::ACTIVE	=> '啟用',
			self::INACTIVE 	=> '停用',
        };
    }
	
	public static function getLabelByValue($value) : string
	{
		#型別要一樣
		$value = intval($value);
		
		return match($value)
		{
			self::ACTIVE->value		=> self::ACTIVE->label(),
			self::INACTIVE->value	=> self::INACTIVE->label(),
			default => 'UNKNOW',
		};
	}
}
