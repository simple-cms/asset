<?php

Route::group(['prefix' => config('core.adminURL')], function()
{
  Route::resource(config('asset.assetURL'), 'SimpleCms\Asset\AdminController');
});

Route::get('asset/{slug}', ['uses' => 'SimpleCms\Asset\PublicController@show', 'as' => 'asset.show']);
