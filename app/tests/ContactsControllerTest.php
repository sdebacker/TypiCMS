<?php
use TypiCMS\Modules\Contacts\Models\Contact;
use Illuminate\Support\Facades\Crypt;

class ContactsControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        // Contact::shouldReceive('getAll')->once()->andReturn(true);
        $view = 'contacts.admin.index';
        $this->registerNestedView($view);

        $this->get('admin/contacts');
        $contacts = $this->nestedViewsData[$view]['models'];

        $this->assertNestedViewHas($view, 'models');
        $this->assertInstanceOf('Illuminate\Pagination\Paginator', $contacts);
    }

    public function testStoreFails()
    {
        $input = array();
        $this->call('POST', 'admin/contacts', $input);
        $this->assertRedirectedToRoute('admin.contacts.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new StdClass;
        $object->id = 1;
        Contact::shouldReceive('create')->once()->andReturn($object);
        $input = array('title' => 'mr', 'first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john@doe.com', 'message' => 'Hello', 'my_time' => Crypt::encrypt(time()-60));
        $this->call('POST', 'admin/contacts', $input);
        $this->assertRedirectedToRoute('admin.contacts.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new StdClass;

        $object->id = 1;
        Contact::shouldReceive('create')->once()->andReturn($object);
        $input = array('title' => 'mr', 'first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john@doe.com', 'message' => 'Hello', 'my_time' => Crypt::encrypt(time()-60), 'exit' => true);
        $this->call('POST', 'admin/contacts', $input);
        $this->assertRedirectedToRoute('admin.contacts.index');
    }

}
