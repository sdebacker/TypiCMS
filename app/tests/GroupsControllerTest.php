<?php
class GroupsControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        $this->get('admin/groups');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testStoreFails()
    {
        $input = [];
        $this->call('POST', 'admin/groups', $input);
        $this->assertRedirectedToRoute('admin.groups.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $input = ['name' => 'test', 'permissions' => []];
        $this->call('POST', 'admin/groups', $input);
        $this->assertRedirectedToRoute('admin.groups.edit', array('id' => 4));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $input = ['name' => 'test', 'permissions' => [], 'exit' => true];
        $this->call('POST', 'admin/groups', $input);
        $this->assertRedirectedToRoute('admin.groups.index');
    }

}
