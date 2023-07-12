<?php

namespace laspi94\CsgoServerApi\Contracts;

use laspi94\CsgoServerApi\Classes\Command;
use laspi94\CsgoServerApi\Classes\Server;

interface CommandExecutor
{
	public function __construct(Summary $summary = null);

	public function batch(array $commands, array $servers);

	public function execute(Command $command, Server $server);
}