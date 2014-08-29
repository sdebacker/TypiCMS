<?php
use TypiCMS\Modules\Menus\Models\Menu;

class MenusControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        // Menu::shouldReceive('getAll')->once()->andReturn(true);
        $view = 'menus.admin.index';
        $this->registerNestedView($view);

        $this->get('admin/menus');
        $menus = $this->nestedViewsData[$view]['models'];

        $this->assertNestedViewHas($view, 'models');
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $menus);
    }

    public function testStoreFails()
    {
        $input = array('name' => '');
        $this->call('POST', 'admin/menus', $input);
        $this->assertRedirectedToRoute('admin.menus.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new StdClass;

        $object->id = 1;
        Menu::shouldReceive('create')->once()->andReturn($object);
        $input = array('name' => 'test');
        $this->call('POST', 'admin/menus', $input);
        $this->assertRedirectedToRoute('admin.menus.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new StdClass;

        $object->id = 1;
        Menu::shouldReceive('create')->once()->andReturn($object);
        $input = array('name' => 'test', 'exit' => true);
        $this->call('POST', 'admin/menus', $input);
        $this->assertRedirectedToRoute('admin.menus.index');
    }

}
