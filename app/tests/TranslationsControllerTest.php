<?php
use TypiCMS\Modules\Translations\Models\Translation;

class TranslationsControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        $this->get('admin/translations');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testStoreFails()
    {
        $input = [];
        $this->call('POST', 'admin/translations', $input);
        $this->assertRedirectedToRoute('admin.translations.create');
        $this->assertSessionHasErrors('key');
    }

    public function testStoreSuccess()
    {
        $object = new stdClass;

        $object->id = 1;
        Translation::shouldReceive('create')->once()->andReturn($object);
        $input = array('key' => 'test');
        $this->call('POST', 'admin/translations', $input);
        $this->assertRedirectedToRoute('admin.translations.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new stdClass;

        $object->id = 1;
        Translation::shouldReceive('create')->once()->andReturn($object);
        $input = array('key' => 'test', 'exit' => true);
        $this->call('POST', 'admin/translations', $input);
        $this->assertRedirectedToRoute('admin.translations.index');
    }

}
