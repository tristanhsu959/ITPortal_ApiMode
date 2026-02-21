<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Exception;

class OptionRepository extends Repository
{
	
	public function __construct()
	{
		
	}
	
	/* Get role list from DB 
	 * @params: 
	 * @return: array
	 */
	public function getRoles()
	{
		try
		{
			$db = $this->connectItPortal('role');
				
			$result = $db
				->select('roleId', 'roleName', 'roleGroup')
				->get()
				->toArray();
					
			return $result;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return FALSE;
		}
	}
}
