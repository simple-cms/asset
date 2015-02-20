<?php namespace SimpleCms\Asset;

use SimpleCms\Core\BaseController;
use Input;
use Redirect;

class AdminController extends BaseController {

  /**
   * Store our RepositoryInterface implementation.
   *
   * @var Simple\Asset\RepositoryInterface
   */
  protected $asset;

  /**
   * Set up the class
   *
   * @param Simple\Asset\RepositoryInterface $page
   *
   * @return void
   */
  public function __construct(RepositoryInterface $asset)
  {
    // Call the parent constructor just in case
    parent::__construct();

    // Set up our Model Interface
    $this->asset = $asset;
  }

  /**
   * Display the specified resource.
   *
   * @return Response
   */
  public function index()
  {
    return view('asset::Admin/Index', [
      'assets' => $this->asset->all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('asset::Admin/Form');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(CreateRequest $request)
  {
    $asset = $this->asset->store($request->all());

    return Redirect::route('control.asset.index')->with([
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
    return view('asset::Admin/Form', [
      'asset' => $this->page->getById($id)
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @return Response
   */
  public function update(UpdateRequest $request)
  {
    $asset = $this->asset->update($request->route->parameter('asset'), $request->all());

    return Redirect::route('control.asset.index')->with([
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
    $asset = $this->asset->destroy($id);

    if ($asset)
    {
      return Redirect::route('control.asset.index')->with([
        'flash-type' => 'success',
        'flash-message' => 'Page successfully deleted!'
      ]);
    }

    return Redirect::route('control.asset.index')->with([
      'flash-type' => 'error',
      'flash-message' => 'Failed to delete asset!'
    ]);
  }

}