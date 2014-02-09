<?php
use TypiCMS\Modules\Categories\Models\Category;

class CategoriesControllerTest extends TestCase {

	public function tearDown()
	{
		Mockery::close();
	}

	public function testAdminIndex()
	{
		// Category::shouldReceive('getAll')->once()->andReturn(true);
		$view = 'categories.admin.index';
		$this->registerNestedView($view);

		$response = $this->get('admin/categories');
		$categories = $this->nestedViewsData[$view]['models'];

		$this->assertNestedViewHas($view, 'models');
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $categories);
	}

	public function testStoreFails()
	{
		$input = array('fr[title]' => 'test', 'fr[slug]' => '', 'position' => 1);
		$this->call('POST', 'admin/categories', $input);
		$this->assertRedirectedToRoute('admin.categories.create');
		$this->assertSessionHasErrors();
	}

	public function testStoreSuccess()
	{
		$input = array('fr[title]' => 'test', 'fr[slug]' => 'test', 'position' => 1);
		$this->call('POST', 'admin/categories', $input);
		$this->assertRedirectedToRoute('admin.categories.edit', array('id' => 1));
	}

	public function testStoreSuccessWithRedirectToList()
	{
		$input = array('fr[title]' => 'test', 'fr[slug]' => 'test', 'position' => 1, 'exit' => true);
		$this->call('POST', 'admin/categories', $input);
		$this->assertRedirectedToRoute('admin.categories.index');
	}

}