<?php

class NewsControllerTest extends TestCase {

	public function testAdminIndex()
	{
		$view = 'admin.news.index';
		$this->registerNestedView($view);
		$this->client->request('GET', 'admin/news');
		$this->assertNestedViewHas($view, 'models');
		$this->assertNestedViewHas($view, 'list');
	}

}