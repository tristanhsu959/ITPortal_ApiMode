<?php

namespace App\ViewModels\Attributes;

use App\Enums\FormAction;
use Illuminate\Support\Arr;

#Breadcrumb | backurl
trait attrActionBar
{
	/* Breadcrumb of action bar (default)
	 * @params: 
	 * @return: void
	 */
	private function _defaultBreadcrumb()
	{
		$breadcrumb 	= [];
		$action 		= data_get($this->_data, 'action', '');
		
		$breadcrumb[] 	= $this->_title;
		$actionName 	= $action->label();
		
		if (empty($actionName))
			return $breadcrumb;
		
		$breadcrumb[] = $actionName;
		
		return $breadcrumb;
	}
	
	private function _customBreadcrumb($actions = [])
	{
		$breadcrumb = Arr::prepend($actions, $this->_title);
		
		return $breadcrumb;
	}
	
	public function backRoute()
	{
		$action = data_get($this->_data, 'action', '');
		$except = [FormAction::SIGNIN->value, FormAction::HOME->value, FormAction::LIST->value];
		
		if (in_array($action->value, $except))
			return '';
		else
			return $this->_backRoute;
	}
}