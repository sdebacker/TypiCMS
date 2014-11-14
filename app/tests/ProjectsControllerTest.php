<?php
use TypiCMS\Modules\Projects\Models\Project;

class ProjectsControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testAdminIndex()
    {
        $this->get('admin/projects');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testStoreFails()
    {
        $input = array('fr.title' => 'test', 'fr.slug' => '', 'category_id' => 1, 'tags' => '');
        $this->call('POST', 'admin/projects', $input);
        $this->assertRedirectedToRoute('admin.projects.create');
        $this->assertSessionHasErrors('fr.slug');
    }

    public function testStoreSuccess()
    {
        $object = new Project;
        $object->id = 1;
        Project::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'fr.slug' => 'test', 'category_id' => 1, 'tags' => '');
        $this->call('POST', 'admin/projects', $input);
        $this->assertRedirectedToRoute('admin.projects.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new Project;
        $object->id = 1;
        Project::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'fr.slug' => 'test', 'category_id' => 1, 'tags' => '', 'exit' => true);
        $this->call('POST', 'admin/projects', $input);
        $this->assertRedirectedToRoute('admin.projects.index');
    }

}
