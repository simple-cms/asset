<?php namespace SimpleCms\Media;

use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('simple-cms/media');

    require __DIR__.'/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
    $this->app->bind('SimpleCms\Media\RepositoryInterface', function($app)
    {
      return new EloquentRepository(new MediaFile);
    });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
