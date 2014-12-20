<?php

Route::resource(Config::get('media::mediaURL'), 'SimpleCms\Media\PublicController');

Route::group(['prefix' => Config::get('core::adminURL')], function()
{
  Route::resource(Config::get('media::mediaURL'), 'SimpleCms\Media\AdminController');
});