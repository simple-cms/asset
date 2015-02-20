<?php

use Illuminate\Http\Request;
use League\Glide\ServerFactory;

Route::group(['prefix' => config('core.adminURL')], function()
{
  Route::resource(config('asset.assetURL'), 'SimpleCms\Asset\AdminController');
});

Route::get('asset/{slug}', function(Request $request) {
  return ServerFactory::create(config('asset.glideConfiguration'))->outputImage($request);
});
