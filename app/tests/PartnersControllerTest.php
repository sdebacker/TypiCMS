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
        // Partner::shouldReceive('getAll')->once()->andReturn(true);
        $view = 'partners.admin.index';
        $this->registerNestedView($view);

        $this->get('admin/partners');
        $partners = $this->nestedViewsData[$view]['models'];

        $this->assertNestedViewHas($view, 'models');
        $this->assertInstanceOf('Illuminate\Pagination\Paginator', $partners);
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
        $object = new StdClass;

        $object->id = 1;
        Partner::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'fr.slug' => 'test', 'fr.body' => '');
        $this->call('POST', 'admin/partners', $input);
        $this->assertRedirectedToRoute('admin.partners.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new StdClass;

        $object->id = 1;
        Partner::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'fr.slug' => 'test', 'fr.body' => '', 'exit' => true);
        $this->call('POST', 'admin/partners', $input);
        $this->assertRedirectedToRoute('admin.partners.index');
    }

}
