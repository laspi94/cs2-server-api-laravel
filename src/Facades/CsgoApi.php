<?php namespace laspi94\CsgoServerApi\Facades;

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