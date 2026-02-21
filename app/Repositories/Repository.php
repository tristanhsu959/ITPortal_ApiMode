<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class Repository
{
	protected function connectItPortal($table = NULL)
	{
		if (empty($table))
			return DB::connection('ItPortal');
		else
			return DB::connection('ItPortal')->table($table); #無法用nolock
	}
}
