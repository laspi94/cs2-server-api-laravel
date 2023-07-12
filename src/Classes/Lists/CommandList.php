<?php

namespace laspi94\CsgoServerApi\Classes\Lists;

use laspi94\CsgoServerApi\Classes\Command;

class CommandList extends BaseList
{
	protected $itemClass = Command::class;

	/**
	 * @param array $params
	 *
	 * @return Command
	 */
	protected function buildItem(...$params)
	{
		return new Command(...func_get_args());
	}
}