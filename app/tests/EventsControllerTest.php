<?php
use TypiCMS\Modules\Events\Models\Event;

class EventsControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        $this->get('admin/events');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testStoreFails()
    {
        $input = array();
        $this->call('POST', 'admin/events', $input);
        $this->assertRedirectedToRoute('admin.events.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new Event;
        $object->id = 1;
        Event::shouldReceive('create')->once()->andReturn($object);
        $input = array('start_date' => '2014-03-10', 'end_date' => '2014-03-10');
        $this->call('POST', 'admin/events', $input);
        $this->assertRedirectedToRoute('admin.events.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new Event;
        $object->id = 1;
        Event::shouldReceive('create')->once()->andReturn($object);
        $input = array('start_date' => '2014-03-10', 'end_date' => '2014-03-10', 'exit' => true);
        $this->call('POST', 'admin/events', $input);
        $this->assertRedirectedToRoute('admin.events.index');
    }

}
