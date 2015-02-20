<?php

Route::group(['prefix' => config('core.adminURL')], function()
{
  Route::resource(config('asset.assetURL'), 'SimpleCms\Asset\AdminController');
});