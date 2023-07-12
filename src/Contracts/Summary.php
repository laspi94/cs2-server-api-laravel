<?php

namespace laspi94\CsgoServerApi\Contracts;

interface Summary
{
	public function attach($command, $server, string $response);

	public function getSummary();
}