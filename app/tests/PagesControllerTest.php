<?php
use TypiCMS\Modules\Pages\Models\Page;

class PagesControllerTest extends TestCase {

	public function tearDown()
	{
		Mockery::close();
	}

	public function testRoot()
	{
		$this->get('/');
	}

	public function testHomepages()
	{
		foreach (Config::get('app.locales') as $locale) {
			$this->get($locale);
		}
	}

	public function testAdminIndex()
	{
		// Page::shouldReceive('getAll')->once();

		$view = 'pages.admin.index';
		$this->registerNestedView($view);
		$this->get('admin/pages');
		$this->assertNestedViewHas($view, 'models');
	}

	// public function testStoreFails()
	// {
	// 	Input::replace($input = ['template' => 'ss']);

	// 	$this->call('POST', 'admin/pages');

	// 	$this->assertRedirectedToRoute('admin.pages.create');
	// 	$this->assertSessionHasErrors(['template']);
	// }

	// public function testStoreSuccess()
	// {
	// 	Input::replace($input = ['template' => '']);

	// 	// \TypiCMS\Models\Page::shouldReceive('create')->once();

	// 	$this->call('POST', 'admin/pages');

	// 	$this->assertRedirectedToRoute('admin.pages.edit', [], 'flash');
	// }

}