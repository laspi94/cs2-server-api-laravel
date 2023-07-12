<?php

namespace laspi94\CsgoServerApi\Tests\Unit;

use laspi94\CsgoServerApi\Classes\Server;
use laspi94\CsgoServerApi\InvalidAddressException;
use laspi94\CsgoServerApi\Tests\Base;

class ServerTest extends Base
{
	public function test_server_can_be_instantiated_by_address()
	{
		$address = '177.54.150.15:27001';

		$server = new Server($address);

		$this->assertEquals('177.54.150.15', $server->getIp());
		$this->assertEquals('27001', $server->getPort());
	}

	public function test_server_can_be_instantiated_by_ip_and_port()
	{
		$server = new Server('177.54.150.15', 27001);

		$this->assertEquals('177.54.150.15', $server->getIp());
		$this->assertEquals('27001', $server->getPort());
	}

	public function test_server_will_raise_exception_on_invalid_address()
	{
		$this->expectException(InvalidAddressException::class);

		$address = '177.54.150.15:123456';

		$server = new Server($address);

		$this->assertEquals('177.54.150.15', $server->getIp());
		$this->assertEquals('27001', $server->getPort());
	}

}