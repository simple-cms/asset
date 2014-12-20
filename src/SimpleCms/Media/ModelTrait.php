<?php namespace SimpleCms\Media;

trait ModelTrait {

  public function media()
  {
    return $this->morphMany('Media', 'media');
  }

}