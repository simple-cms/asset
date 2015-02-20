<?php

Route::group(['prefix' => config('core.adminURL')], function()
{
  Route::resource(config('asset.assetURL'), 'SimpleCms\Asset\AdminController');
});

Route::get('asset/{slug}', function ($request)
{
  $glide = League\Glide\ServerFactory::create([
    'source' => public_path() .'/assets/images',
    'cache' => storage_path() . '/framework/cache/images',
    'max_image_size' => 2560*2000,
    'base_url' => '/asset/',
  ]);

  $glide->outputImage($request)->getSourcePath();
});

