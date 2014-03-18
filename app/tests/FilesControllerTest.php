<?php
use TypiCMS\Modules\Files\Models\File;

class FilesControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        // File::shouldReceive('getAll')->once()->andReturn(true);
        $view = 'files.admin.index';
        $this->registerNestedView($view);

        $response = $this->get('admin/pages/1/files');
        $files = $this->nestedViewsData[$view]['models'];

        $this->assertNestedViewHas($view, 'models');
        $this->assertInstanceOf('Illuminate\Pagination\Paginator', $files);
    }

    public function testStoreFails()
    {
        $input = array('fileable_id' => 0);
        $this->call('POST', 'admin/pages/1/files', $input);
        $this->assertRedirectedToRoute('admin.pages.files.create', array('page_id' => 1));
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new StdClass;

        $object->id = 1;
        File::shouldReceive('create')->once()->andReturn($object);
        $input = array('fileable_id' => 1, 'fileable_type' => 1);
        $this->call('POST', 'admin/pages/1/files', $input);
        $this->assertRedirectedToRoute('admin.pages.files.edit', array('page_id' => 1, 'id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new StdClass;

        $object->id = 1;
        File::shouldReceive('create')->once()->andReturn($object);
        $input = array('fileable_id' => 1, 'fileable_type' => 1, 'exit' => true);
        $this->call('POST', 'admin/pages/1/files', $input);
        $this->assertRedirectedToRoute('admin.pages.files.index', array('page_id' => 1));
    }

}
