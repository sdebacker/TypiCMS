<?php
use TypiCMS\Modules\Places\Models\Place;

class PlacesControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        $this->get('admin/places');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testStoreFails()
    {
        $input = ['fr.title' => 'test', 'fr.slug' => ''];
        $this->call('POST', 'admin/places', $input);
        $this->assertRedirectedToRoute('admin.places.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new stdClass;

        $object->id = 1;
        Place::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'fr.slug' => 'test', 'fr.body' => '', 'status' => 0);
        $this->call('POST', 'admin/places', $input);
        $this->assertRedirectedToRoute('admin.places.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new stdClass;

        $object->id = 1;
        Place::shouldReceive('create')->once()->andReturn($object);
        $input = array('title' => 'test', 'slug' => 'test', 'fr.body' => '', 'status' => 0, 'exit' => true);
        $this->call('POST', 'admin/places', $input);
        $this->assertRedirectedToRoute('admin.places.index');
    }

}
