<?php
use TypiCMS\Modules\News\Models\News;

class NewsControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        // News::shouldReceive('getAll')->once()->andReturn(true);
        $view = 'news.admin.index';
        $this->registerNestedView($view);

        $this->get('admin/news');
        $news = $this->nestedViewsData[$view]['models'];

        $this->assertNestedViewHas($view, 'models');
        $this->assertInstanceOf('Illuminate\Pagination\Paginator', $news);
    }

    public function testStoreFails()
    {
        $input = ['date' => ''];
        $this->call('POST', 'admin/news', $input);
        $this->assertRedirectedToRoute('admin.news.create');
        $this->assertSessionHasErrors(['date']);
    }

    public function testStoreSuccess()
    {
        $object = new StdClass;

        $object->id = 1;
        News::shouldReceive('create')->once()->andReturn($object);
        $input = array('date' => '2014-03-10 11:04:00');
        $this->call('POST', 'admin/news', $input);
        $this->assertRedirectedToRoute('admin.news.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new StdClass;

        $object->id = 1;
        News::shouldReceive('create')->once()->andReturn($object);
        $input = array('date' => '2014-03-10 11:04:00', 'exit' => true);
        $this->call('POST', 'admin/news', $input);
        $this->assertRedirectedToRoute('admin.news.index');
    }

}
