<?php
use TypiCMS\Modules\News\Models\News;

class NewsControllerTest extends TestCase {

	public function tearDown()
	{
		Mockery::close();
	}

	public function testAdminIndex()
	{
		// News::shouldReceive('getAll')->once()->andReturn(true);
		$view = 'news.admin.index';
		$this->registerNestedView($view);

		$response = $this->get('admin/news');
		$news = $this->nestedViewsData[$view]['models'];

		$this->assertNestedViewHas($view, 'models');
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $news);
	}

	public function testStoreFails()
	{
		Input::replace($input = ['date' => '']); // 19.02.2014 11:04
		$this->call('POST', 'admin/news', $input);
		$this->assertRedirectedToRoute('admin.news.create');
		$this->assertSessionHasErrors(['date']);
	}

	public function testStoreSuccess()
	{
		$object = new StdClass; // or a new mock object
		$object->id = 1;
		News::shouldReceive('create')->once()->andReturn($object);
		$input = array('date' => '19.02.2014 11:04');
		$this->call('POST', 'admin/news', $input);
		$this->assertRedirectedToRoute('admin.news.edit', array('id' => 1));
	}

	public function testStoreSuccessWithRedirectToList()
	{
		$object = new StdClass; // or a new mock object
		$object->id = 1;
		News::shouldReceive('create')->once()->andReturn($object);
		$input = array('date' => '19.02.2014 11:04', 'exit' => true);
		$this->call('POST', 'admin/news', $input);
		$this->assertRedirectedToRoute('admin.news.index');
	}

}