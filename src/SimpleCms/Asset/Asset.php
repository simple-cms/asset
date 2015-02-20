<?php namespace SimpleCms\Asset;

use SimpleCms\Core\BaseModel;

class Asset extends BaseModel {

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