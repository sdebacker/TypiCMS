<?php
use TypiCMS\Modules\Events\Models\Event;

class EventsControllerTest extends TestCase {

	public function tearDown()
	{
		Mockery::close();
	}

	public function testAdminIndex()
	{
		// Event::shouldReceive('getAll')->once()->andReturn(true);
		$view = 'events.admin.index';
		$this->registerNestedView($view);

		$response = $this->get('admin/events');
		$events = $this->nestedViewsData[$view]['models'];

		$this->assertNestedViewHas($view, 'models');
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $events);
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
		$object = new StdClass; // or a new mock object
		$object->id = 1;
		Event::shouldReceive('create')->once()->andReturn($object);
		$input = array('start_date' => '10.10.2012');
		$this->call('POST', 'admin/events', $input);
		$this->assertRedirectedToRoute('admin.events.edit', array('id' => 1));
	}

	public function testStoreSuccessWithRedirectToList()
	{
		$object = new StdClass; // or a new mock object
		$object->id = 1;
		Event::shouldReceive('create')->once()->andReturn($object);
		$input = array('start_date' => '10.10.2012', 'exit' => true);
		$this->call('POST', 'admin/events', $input);
		$this->assertRedirectedToRoute('admin.events.index');
	}

}