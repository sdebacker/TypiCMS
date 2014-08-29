<?php
use TypiCMS\Modules\Files\Models\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilesControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        // File::shouldReceive('getAll')->once()->andReturn(true);
        $view = 'files.admin.thumbnails';
        $this->registerNestedView($view);

        $this->get('admin/files');
        $files = $this->nestedViewsData[$view]['models'];

        $this->assertNestedViewHas($view, 'models');
        $this->assertInstanceOf('Illuminate\Pagination\Paginator', $files);
    }

    public function testStoreSuccess()
    {
        $object = new StdClass;

        $object->id = 1;
        File::shouldReceive('create')->once()->andReturn($object);
        $this->call('POST', 'admin/files');
        $this->assertRedirectedToRoute('admin.files.edit', array('id' => 1));
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
