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

        $response = $this->get('admin/files');
        $files = $this->nestedViewsData[$view]['models'];

        $this->assertNestedViewHas($view, 'models');
        $this->assertInstanceOf('Illuminate\Pagination\Paginator', $files);
    }

    public function testStoreFails()
    {
        $this->call('POST', 'admin/1/files', $input);
        $this->assertRedirectedToRoute('admin.files.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new StdClass;

        $object->id = 1;
        File::shouldReceive('create')->once()->andReturn($object);
        $this->call('POST', 'admin/files', $input);
        $this->assertRedirectedToRoute('admin.pages.files.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new StdClass;

        $object->id = 1;
        File::shouldReceive('create')->once()->andReturn($object);
        $input = array('exit' => true);
        $this->call('POST', 'admin/files', $input);
        $this->assertRedirectedToRoute('admin.files.index');
    }

}
