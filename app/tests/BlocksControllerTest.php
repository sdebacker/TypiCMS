<?php
use TypiCMS\Modules\Blocks\Models\Block;

class BlocksControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        // Block::shouldReceive('getAll')->once()->andReturn(true);
        $view = 'blocks.admin.index';
        $this->registerNestedView($view);

        $this->get('admin/blocks');
        $blocks = $this->nestedViewsData[$view]['models'];

        $this->assertNestedViewHas($view, 'models');
        $this->assertInstanceOf('Illuminate\Pagination\Paginator', $blocks);
    }

    public function testStoreFails()
    {
        $input = ['name' => '']; // 19.02.2014 11:04
        $this->call('POST', 'admin/blocks', $input);
        $this->assertRedirectedToRoute('admin.blocks.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new StdClass;

        $object->id = 1;
        Block::shouldReceive('create')->once()->andReturn($object);
        $input = array('name' => 'test');
        $this->call('POST', 'admin/blocks', $input);
        $this->assertRedirectedToRoute('admin.blocks.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new StdClass;

        $object->id = 1;
        Block::shouldReceive('create')->once()->andReturn($object);
        $input = array('name' => 'test', 'exit' => true);
        $this->call('POST', 'admin/blocks', $input);
        $this->assertRedirectedToRoute('admin.blocks.index');
    }

}
