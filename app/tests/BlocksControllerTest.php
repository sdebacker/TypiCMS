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
        $this->get('admin/blocks');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testStoreFails()
    {
        $input = ['name' => ''];
        $this->call('POST', 'admin/blocks', $input);
        $this->assertRedirectedToRoute('admin.blocks.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new Block;
        $object->id = 1;
        Block::shouldReceive('create')->once()->andReturn($object);
        $input = array('name' => 'test');
        $this->call('POST', 'admin/blocks', $input);
        $this->assertRedirectedToRoute('admin.blocks.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new Block;
        $object->id = 1;
        Block::shouldReceive('create')->once()->andReturn($object);
        $input = array('name' => 'test', 'exit' => true);
        $this->call('POST', 'admin/blocks', $input);
        $this->assertRedirectedToRoute('admin.blocks.index');
    }

}
