<?php

namespace laspi94\CsgoServerApi\Tests\Unit\Lists;

use laspi94\CsgoServerApi\Classes\Lists\ServerList;
use laspi94\CsgoServerApi\Classes\Server;
use laspi94\CsgoServerApi\Tests\Base;

class ServerListTest extends Base
{
	public function test_server_list_will_add_new_servers()
	{
		$serverList = new ServerList();

		$serverList->addItem(new Server('177.54.150.15:27001'));
		$serverList->addItem([
			new Server('177.54.150.15:27001'),
			new Server('177.54.150.15:27002'),
		]);

		$serverList->addItem('177.54.150.15:27002');
		$serverList->addItem([
			'177.54.150.15:27001',
			'177.54.150.15:27002',
		]);
		$serverList->addItem('177.54.150.15', 27002);
		$serverList->addItem([
			['177.54.150.15', 27001],
			['177.54.150.15', 27002],
		]);

		$list = $serverList->getList();

		$this->assertEquals(9, count($list));
	}

}