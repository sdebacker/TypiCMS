<?php
use TypiCMS\Modules\Partners\Models\Partner;

class PartnersControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        $this->get('admin/partners');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testStoreFails()
    {
        $input = ['fr.title' => 'test', 'fr.slug' => '']; // 19.02.2014 11:04
        $this->call('POST', 'admin/partners', $input);
        $this->assertRedirectedToRoute('admin.partners.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new stdClass;

        $object->id = 1;
        Partner::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'fr.slug' => 'test', 'fr.body' => '', 'position' => '1');
        $this->call('POST', 'admin/partners', $input);
        $this->assertRedirectedToRoute('admin.partners.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new stdClass;

        $object->id = 1;
        Partner::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'fr.slug' => 'test', 'fr.body' => '', 'position' => '1', 'exit' => true);
        $this->call('POST', 'admin/partners', $input);
        $this->assertRedirectedToRoute('admin.partners.index');
    }

}
