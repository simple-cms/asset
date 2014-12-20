<?php namespace SimpleCms\Media;

use SimpleCms\Core\BaseController;
use View;
use Input;
use Redirect;

class AdminController extends BaseController {

  /**
   * Store our RepositoryInterface implementation.
   *
   * @var Simple\Media\RepositoryInterface
   */
  protected $media;

  /**
   * Set up the class
   *
   * @param Simple\Media\RepositoryInterface $page
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
    return View::make('media::Admin/Index', [
      'medias' => $this->media->all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return View::make('media::Admin/Form');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(CreateRequest $request)
  {
    $media = $this->media->store($request->all());

    return Redirect::route('control.media.index')->with([
      'flash-type' => 'success',
      'flash-message' => 'Successfully created '. $request->title .'!'
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @return Response
   */
  public function edit($id)
  {
    return View::make('media::Admin/Form', [
      'media' => $this->page->getById($id)
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @return Response
   */
  public function update(UpdateRequest $request)
  {
    $media = $this->media->update($request->route->parameter('media'), $request->all());

    return Redirect::route('control.media.index')->with([
      'flash-type' => 'success',
      'flash-message' => 'Successfully updated '. $request->title .'!'
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @return Response
   */
  public function destroy($id)
  {
    $media = $this->media->destroy($id);

    if ($media)
    {
      return Redirect::route('control.media.index')->with([
        'flash-type' => 'success',
        'flash-message' => 'Page successfully deleted!'
      ]);
    }

    return Redirect::route('control.media.index')->with([
      'flash-type' => 'error',
      'flash-message' => 'Failed to delete media!'
    ]);
  }

}