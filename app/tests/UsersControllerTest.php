<?php
class UsersControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        $this->get('admin/users');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testStoreFails()
    {
        $input = ['email' => 'test'];
        $this->call('POST', 'admin/users', $input);
        $this->assertRedirectedToRoute('admin.users.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $input = [
            'email' => 'test@test.com',
            'first_name' => 'test',
            'last_name' => 'test',
            'password' => 'testtest',
            'password_confirmation' => 'testtest',
        ];
        $this->call('POST', 'admin/users', $input);
        $this->assertRedirectedToRoute('admin.users.edit', array('id' => 2));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $input = [
            'email' => 'test@test.com',
            'first_name' => 'test',
            'last_name' => 'test',
            'password' => 'testtest',
            'password_confirmation' => 'testtest',
            'exit' => true,
        ];
        $this->call('POST', 'admin/users', $input);
        $this->assertRedirectedToRoute('admin.users.index');
    }

}
