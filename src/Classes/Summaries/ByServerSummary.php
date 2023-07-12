<?php

namespace laspi94\CsgoServerApi\Classes\Summaries;

use laspi94\CsgoServerApi\Contracts\Summary;

class ByServerSummary implements Summary
{
	protected $servers = [];

	public function attach($command, $server, string $response)
	{
		$this->servers[ (string) $server ][ (string) $command ] = $response;
	}

	public function getSummary()
	{
		return $this->servers;
	}
}