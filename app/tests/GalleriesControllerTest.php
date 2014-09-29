<?php
use TypiCMS\Modules\Galleries\Models\Gallery;

class GalleriesControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        $this->get('admin/galleries');
    }

    public function testStoreFails()
    {
        $input = array(
            'en' => array(
                'status' => 1,
            )
        );
        $this->call('POST', 'admin/galleries', $input);
        $this->assertRedirectedToRoute('admin.galleries.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new StdClass;

        $object->id = 1;
        Gallery::shouldReceive('create')->once()->andReturn($object);
        $input = array('name' => 'test');
        $this->call('POST', 'admin/galleries', $input);
        $this->assertRedirectedToRoute('admin.galleries.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new StdClass;

        $object->id = 1;
        Gallery::shouldReceive('create')->once()->andReturn($object);
        $input = array('name' => 'test', 'exit' => true);
        $this->call('POST', 'admin/galleries', $input);
        $this->assertRedirectedToRoute('admin.galleries.index');
    }

}
