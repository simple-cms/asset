<?php namespace SimpleCms\Media;

use SimpleCms\Core\BaseModel;

class MediaFile extends BaseModel {

  protected $fillable = [
    'slug',
    'meta_title',
    'meta_description',
    'title',
    'excerpt'
  ];

  public function media()
  {
      return $this->morphTo();
  }

  public static function boot()
  {
    // Call the parent boot method
    parent::boot();

    // Here we hook into the saving event with a closure
    static::saving(function($model)
    {
      return $model->validate($model->getAttributes(), $model::$rules);
    });
  }

}