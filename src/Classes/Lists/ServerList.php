<?php

namespace laspi94\CsgoServerApi\Classes\Lists;

use laspi94\CsgoServerApi\Classes\Server;
use laspi94\CsgoServerApi\InvalidAddressException;

class ServerList extends BaseList
{
	protected $itemClass = Server::class;

	/**
	 * @param array $params
	 *
	 * @return Server
	 * @throws InvalidAddressException
	 */
	protected function buildItem(...$params)
	{
		return new Server(...func_get_args());
	}
}