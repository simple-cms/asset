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

}