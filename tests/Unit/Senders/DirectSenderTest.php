<?php

namespace laspi94\CsgoServerApi\Tests\Unit\Senders;

use laspi94\CsgoServerApi\Classes\Api;
use laspi94\CsgoServerApi\Classes\Command;
use laspi94\CsgoServerApi\Classes\Senders\DirectSender;
use laspi94\CsgoServerApi\Classes\Server;
use laspi94\CsgoServerApi\Classes\Summaries\ByServerSummary;
use laspi94\CsgoServerApi\Tests\Base;

class DirectSenderTest extends Base
{
	public function test_direct_sender_by_add_server()
	{
		$this->execute_direct_sender_by_method_name('addServer');
	}

	public function test_direct_sender_by_add_servers()
	{
		$this->execute_direct_sender_by_method_name('addServers');
	}

	public function test_direct_sender_by_server()
	{
		$this->execute_direct_sender_by_method_name('server');
	}

	public function test_direct_sender_by_servers()
	{
		$this->execute_direct_sender_by_method_name('servers');
	}

	public function execute_direct_sender_by_method_name($method)
	{
		$this->mock(Api::class, function ($mock) {
			$mock->shouldReceive('send')->once()->andReturn('status-1');
			$mock->shouldReceive('send')->once()->andReturn('status-2');
			$mock->shouldReceive('send')->once()->andReturn('stats-1');
			$mock->shouldReceive('send')->once()->andReturn('stats-2');
		});

		$direct = new DirectSender(ByServerSummary::class);

		$command1 = new Command('status', 2500, false);
		$command2 = new Command('stats', 1000, true);

		$server1 = new Server('177.54.150.15:27001');
		$server2 = new Server('177.54.150.15:27002');

		$direct->addCommand($command1);
		$direct->addCommand($command2);

		$direct->$method($server1);
		$direct->$method($server2);

		$summary = $direct->send();

		$expected = [
			"177.54.150.15:27001" => [
				"status" => "status-1",
				"stats"  => "stats-1",
			],
			"177.54.150.15:27002" => [
				"status" => "status-2",
				"stats"  => "stats-2",
			],
		];

		$this->assertEquals($expected, $summary);
	}
}