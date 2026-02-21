<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ServiceException extends Exception
{
	private $_originalMsg;
	private $_params;
	
    public function __construct($message, $originalMsg, array $params = [], $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
		$this->_originalMsg = $originalMsg;
		$this->_params = params;
		
		#Service layer Log : 記錄原始Message
		#$message : customize by user
		#$originalMsg : original message => $e->getMessage()
		Log::channel('appServiceLog')->error($this->_originalMsg, $this->_params);
    }
}
