<?php

Route::group(['prefix' => 'control'], function()
{
  Route::resource('media', 'SimpleCms\Media\AdminController');
});