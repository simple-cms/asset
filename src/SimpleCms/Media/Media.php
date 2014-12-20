<?php namespace SimpleCms\Media;

use SimpleCms\Core\BaseModel;

class Media extends BaseModel {

  protected $fillable = [
    'media_id',
    'media_type',
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