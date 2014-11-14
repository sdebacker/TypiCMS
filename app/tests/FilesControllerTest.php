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
        $this->get('admin/files');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testStoreSuccess()
    {
        $object = new File;
        $object->id = 1;
        File::shouldReceive('create')->once()->andReturn($object);
        $this->call('POST', 'admin/files');
        $this->assertRedirectedToRoute('admin.files.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new File;
        $object->id = 1;
        File::shouldReceive('create')->once()->andReturn($object);
        $input = array('exit' => true);
        $this->call('POST', 'admin/files', $input);
        $this->assertRedirectedToRoute('admin.files.index');
    }

}
