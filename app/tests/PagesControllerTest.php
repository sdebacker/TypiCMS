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

	public function testStoreFails()
	{
		$input = array('fr.title' => 'test', 'fr.slug' => '');
		$this->call('POST', 'admin/pages', $input);
		$this->assertRedirectedToRoute('admin.pages.create');
		$this->assertSessionHasErrors('fr.slug');
	}

	public function testStoreSuccess()
	{
		$input = array('fr.title' => 'test', 'fr.slug' => 'test');
		$this->call('POST', 'admin/pages', $input);
		$this->assertRedirectedToRoute('admin.pages.edit', array('id' => 1));
	}

	public function testStoreSuccessWithRedirectToList()
	{
		$input = array('fr.title' => 'test', 'fr.slug' => 'test', 'exit' => true);
		$this->call('POST', 'admin/pages', $input);
		$this->assertRedirectedToRoute('admin.pages.index');
	}

}