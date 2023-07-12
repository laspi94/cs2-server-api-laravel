<?php namespace foxx\CsgoServerApi\Facades;

use Illuminate\Support\Facades\Facade;

class CsgoApi extends Facade
{
	/**
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'CsgoApi';
	}
}