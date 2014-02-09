<?php namespace TypiCMS\Services\Form;

use Illuminate\Support\ServiceProvider;

use TypiCMS\Services\Form\Page\PageForm;
use TypiCMS\Services\Form\Page\PageFormLaravelValidator;
use TypiCMS\Services\Form\File\FileForm;
use TypiCMS\Services\Form\File\FileFormLaravelValidator;
use TypiCMS\Services\Form\Menu\MenuForm;
use TypiCMS\Services\Form\Menu\MenuFormLaravelValidator;
use TypiCMS\Services\Form\Menulink\MenulinkForm;
use TypiCMS\Services\Form\Menulink\MenulinkFormLaravelValidator;
use TypiCMS\Services\Form\Project\ProjectForm;
use TypiCMS\Services\Form\Project\ProjectFormLaravelValidator;
use TypiCMS\Services\Form\Category\CategoryForm;
use TypiCMS\Services\Form\Category\CategoryFormLaravelValidator;
use TypiCMS\Services\Form\Event\EventForm;
use TypiCMS\Services\Form\Event\EventFormLaravelValidator;
use TypiCMS\Services\Form\News\NewsForm;
use TypiCMS\Services\Form\News\NewsFormLaravelValidator;
use TypiCMS\Services\Form\User\UserForm;
use TypiCMS\Services\Form\User\UserFormLaravelValidator;

class FormServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;

		$app->bind('TypiCMS\Services\Form\Page\PageForm', function($app)
		{
			return new PageForm(
				new PageFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Pages\Repositories\PageInterface')
			);
		});

		$app->bind('TypiCMS\Services\Form\File\FileForm', function($app)
		{
			return new FileForm(
				new FileFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Files\Repositories\FileInterface')
			);
		});
		
		$app->bind('TypiCMS\Services\Form\Menu\MenuForm', function($app)
		{
			return new MenuForm(
				new MenuFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Menus\Repositories\MenuInterface')
			);
		});
		
		$app->bind('TypiCMS\Services\Form\Menulink\MenulinkForm', function($app)
		{
			return new MenulinkForm(
				new MenulinkFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface')
			);
		});

		$app->bind('TypiCMS\Services\Form\Event\EventForm', function($app)
		{
			return new EventForm(
				new EventFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Events\Repositories\EventInterface')
			);
		});

		$app->bind('TypiCMS\Services\Form\News\NewsForm', function($app)
		{
			return new NewsForm(
				new NewsFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Repositories\News\NewsInterface')
			);
		});

		$app->bind('TypiCMS\Services\Form\Project\ProjectForm', function($app)
		{
			return new ProjectForm(
				new ProjectFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Projects\Repositories\ProjectInterface')
			);
		});

		$app->bind('TypiCMS\Services\Form\Category\CategoryForm', function($app)
		{
			return new CategoryForm(
				new CategoryFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Categories\Repositories\CategoryInterface')
			);
		});

		$app->bind('TypiCMS\Services\Form\User\UserForm', function($app)
		{
			return new UserForm(
				new UserFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Repositories\User\UserInterface')
			);
		});

	}

}