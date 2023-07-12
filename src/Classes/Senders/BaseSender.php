<?php

namespace laspi94\CsgoServerApi\Classes\Senders;

use laspi94\CsgoServerApi\Classes\Api;
use laspi94\CsgoServerApi\Classes\Summaries\ByServerSummary;
use laspi94\CsgoServerApi\Contracts\Summary;

abstract class BaseSender
{
	/** @var Api */
	protected $api;

	/** @var Summary */
	protected $summary;

	public function __construct($summaryClass = ByServerSummary::class)
	{
		$this->api = app(Api::class);
		$this->summary = new $summaryClass();
	}

	abstract public function send();
}