<?php

namespace laspi94\CsgoServerApi\Traits;

use laspi94\CsgoServerApi\Classes\Lists\ServerList;

trait HandlesServerList
{
	/** @var ServerList */
	protected $servers;

	public function bootServerList()
	{
		$this->servers = new ServerList();
	}

	public function addServers(...$args)
	{
		$this->servers->addItem(...$args);

		return $this;
	}

	public function servers(...$args)
	{
		return $this->addServers(...$args);
	}

	public function addServer(...$args)
	{
		return $this->addServers(...$args);
	}

	public function server(...$args)
	{
		return $this->addServers(...$args);
	}
}