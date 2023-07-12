<?php

namespace laspi94\CsgoServerApi\Classes\Senders;

use laspi94\CsgoServerApi\Classes\Command;
use laspi94\CsgoServerApi\Classes\Server;
use laspi94\CsgoServerApi\Classes\Summaries\ByCommandSummary;
use laspi94\CsgoServerApi\Traits\HandlesCommandList;
use laspi94\CsgoServerApi\Traits\HandlesServerList;

class DirectSender extends BaseSender
{
	use HandlesCommandList;
	use HandlesServerList;

	public function __construct($summaryClass = ByCommandSummary::class)
	{
		parent::__construct($summaryClass);

		$this->bootCommandList();
		$this->bootServerList();
	}

	public function send()
	{
		foreach ($this->commands->getList() as $command) {
			$this->executeOnServers($command);
		}

		return $this->summary->getSummary();
	}

	protected function executeOnServers(Command $command)
	{
		foreach ($this->servers->getList() as $server) {
			$response = $this->execute($command, $server);
			$this->summary->attach($command, $server, $response);
		}
	}

	/**
	 * @param Command $command - command to be executed
	 * @param Server  $server  - server to execute
	 *
	 * @return string|bool - response string if successful or false if failed
	 */
	public function execute(Command $command, Server $server)
	{
		return $this->api->send($command, $server);
	}
}