<?php namespace SimpleCms\Asset;

use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider {

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
    // Register our package views
    $this->loadViewsFrom(__DIR__.'/../../views', 'asset');

    // Register our package translation files
    $this->loadTranslationsFrom(__DIR__.'/../../lang', 'asset');

    // Register the files our package should publish
    $this->publishes([
      // Publish our views
      __DIR__.'/../../views' => base_path('resources/views/vendor/asset'),
      // Publish our config
      __DIR__.'/../../config/asset.php' => config_path('asset.php'),
    ]);

    require __DIR__.'/../../routes.php';
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind('SimpleCms\Asset\RepositoryInterface', function($app)
    {
      return new EloquentRepository(new Asset);
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
