<?php namespace SimpleCms\Asset;

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
   * Display the specified resource.
   *
   * @return Response
   */
  public function index()
  {
    return view('media::Public/Index', [
      'metaTitle' => 'Home page title',
      'metaDesciption' => 'Home page description',
      'media' => $this->media->paginate()
    ]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function show($slug)
  {
    return view('media::Public/Show', [
      'metaTitle' => 'slug page title',
      'metaDesciption' => 'slug page description',
      'media' => $this->media->getFirstBy('slug', $slug)
    ]);
  }

}