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
        // Project::shouldReceive('getAll')->once()->andReturn(true);
        $view = 'projects.admin.index';
        $this->registerNestedView($view);

        $this->get('admin/projects');
        $projects = $this->nestedViewsData[$view]['models'];

        $this->assertNestedViewHas($view, 'models');
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $projects);
    }

    public function testStoreFails()
    {
        $input = array('fr.title' => 'test', 'fr.slug' => '', 'category_id' => 1, 'tags' => ''); // 19.02.2014 11:04
        $this->call('POST', 'admin/projects', $input);
        $this->assertRedirectedToRoute('admin.projects.create');
        $this->assertSessionHasErrors('fr.slug');
    }

    public function testStoreSuccess()
    {
        $object = new StdClass;

        $object->id = 1;
        Project::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'fr.slug' => 'test', 'category_id' => 1, 'tags' => '');
        $this->call('POST', 'admin/projects', $input);
        $this->assertRedirectedToRoute('admin.projects.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new StdClass;

        $object->id = 1;
        Project::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'fr.slug' => 'test', 'category_id' => 1, 'tags' => '', 'exit' => true);
        $this->call('POST', 'admin/projects', $input);
        $this->assertRedirectedToRoute('admin.projects.index');
    }

}
