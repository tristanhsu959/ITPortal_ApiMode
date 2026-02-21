<?php

namespace App\Services;

use App\Repositories\OptionRepository;
use App\Libraries\ResponseLib;
use App\Enums\RoleGroup;
use App\Enums\Area;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use Exception;

#表單選項參數提供: 集中在此提供
class OptionService
{
	public function __construct(protected OptionRepository $_repository)
	{
	}
	
	/* User role options
	 * @params: string
	 * @return: array
	 */
	public function getRoleOptions($isEnable = FALSE)
	{
		try 
		{
			$result = $this->_repository->getRoles();
		
			$mapped = Arr::mapWithKeys($result, function ( $item, int $key) use($isEnable) {
				if (($isEnable && ($item['roleGroup'] != RoleGroup::SUPERVISOR->value)) OR $isEnable === FALSE)
					return [$item['roleId'] => $item['roleName']];
				else
					return []; #必須要return
			});
			
			return $mapped;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return [];
		}
	}
	
	public function getEnableRoleOptions()
	{
		$isEnable = TRUE;
		return $this->getRoleOptions($isEnable);
	}
	
	
}
