<?php

class PagesControllerTest extends TestCase {

	public function testRoot()
	{
		$this->client->request('GET', '/');
	}

	public function testHomepages()
	{
		foreach (Config::get('app.locales') as $locale) {
			$this->client->request('GET', $locale);
		}
	}

	public function testAdminIndex()
	{
		$view = 'admin.pages.index';
		$this->registerNestedView($view);
		$this->client->request('GET', 'admin/pages');
		$this->assertNestedViewHas($view, 'models');
	}

}