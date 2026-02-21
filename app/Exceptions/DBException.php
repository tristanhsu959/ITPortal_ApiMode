<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class DBException extends Exception
{
	private $_extra;
	
    public function __construct($message, array $extra = [], $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
		$this->_extra = $extra;
		
		#DB layer log:記錄原始Message
		Log::channel('appDBLog')->error($this->getMessage(), $this->_extra);
    }
}
