<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

trait MenuTrait
{
	/* Get menu list
	 * @params: 
	 * @return: array
	 */
	public function getMenu()
	{
		$menu = [];
		$enabled 	= config('web.menu.enabled');
		$available 	= config('web.menu.available');
		
		foreach($enabled as $itemKey)
		{
			$item = data_get($available, $itemKey, NULL);
			
			if (! empty($item))
				$menu[$itemKey] = $item;
		}
		
		return $menu;
	}
	
	public function getEnabledMenuKeys()
	{
		return config('web.menu.enabled');
	}
}