<?php
use TypiCMS\Modules\Menulinks\Models\Menulink;

class MenulinksControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        // Menulink::shouldReceive('getAll')->once()->andReturn(true);
        $view = 'menulinks.admin.index';
        $this->registerNestedView($view);

        $this->get('admin/menus/1/menulinks');
        $menulinks = $this->nestedViewsData[$view]['models'];

        $this->assertNestedViewHas($view, 'models');
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $menulinks);
    }

    public function testStoreFails()
    {
        $input = array();
        $this->call('POST', 'admin/menus/1/menulinks', $input);
        $this->assertRedirectedToRoute('admin.menus.menulinks.create', array('menu_id' => 1));
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new StdClass;

        $object->id = 1;
        Menulink::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'menu_id' => '1');
        $this->call('POST', 'admin/menus/1/menulinks', $input);
        $this->assertRedirectedToRoute('admin.menus.menulinks.edit', array('menu_id' => 1, 'id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new StdClass;

        $object->id = 1;
        Menulink::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'menu_id' => '1', 'exit' => true);
        $this->call('POST', 'admin/menus/1/menulinks', $input);
        $this->assertRedirectedToRoute('admin.menus.menulinks.index', array('menu_id' => 1));
    }

}
