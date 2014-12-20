<?php namespace SimpleCms\Media;

trait ModelTrait {

  /**
   * Handles our morphToMany relationship
   *
   * @return SimpleCms\Media\MediaFile
   */
  public function media()
  {
    return $this->morphToMany('SimpleCms\Media\MediaFile', 'media_attachment');
  }

}