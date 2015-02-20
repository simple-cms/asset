<?php namespace SimpleCms\Asset;

use Illuminate\Http\Request;
use SimpleCms\Asset\RepositoryInterface;
use SimpleCms\Core\BaseController;

class PublicController extends BaseController {

  /**
   * Store our RepositoryInterface implementation.
   *
   * @var Simple\Media\RepositoryInterface
   */
  protected $media;

  /**
   * Set up the class
   *
   * @param Simple\Media\RepositoryInterface $media
   *
   * @return void
   */
  public function __construct(RepositoryInterface $media)
  {
    // Call the parent constructor just in case
    parent::__construct();

    // Set up our Model Interface
    $this->media = $media;
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function show($slug, Request $request)
  {
    $glide = \League\Glide\ServerFactory::create([
      'source' => public_path() .'/assets/images',
      'cache' => storage_path() . '/framework/cache/images',
      'max_image_size' => 2560*2000,
      'base_url' => '/asset/',
      'driver' => 'gd',
    ]);

    $glide->outputImage($request);
  }
}