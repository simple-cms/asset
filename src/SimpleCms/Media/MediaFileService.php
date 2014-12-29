<?php namespace Wfuk\Media;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\ImageManager as Image;
use Symfony\Component\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;

class MediaFileService
{
  // Holds our Intervention\Image instance
  protected $image;

  // Holds our Symfony\Component\Filesystem\Filesystem instance
  protected $filesystem;

  /**
   * Do we want to retain the original filename?
   *
   * @var bool
   */
  protected $retainOriginalFilename;

  public function __construct(Image $image, Filesystem $filesystem)
  {
    $this->image = $image;
    $this->filesystem = $filesystem;

    // Grab the various configuration values we need
    $this->retainOriginalFilename = Config::get('media::retainOriginalFilename');
    $this->newFilenameLength =Config::get('media::newFilenameLength');
  }

  public function resize(UploadedFile $image, string $type)
  {
    // Get the filename we want to use for the new image(s)
    $newFileName = $this->generateFilename($image) . '.' . $image->guessExtension();

    // Grab the array of images sizes we need
    // TODO rather not have Config::get in here - Ideally a method on the model would return the array
    $mediaConfiguration = Config::get($type .'::'. 'mediaConfiguration');

    // Loop through each of the image sizes
    foreach ($mediaConfiguration['sizes'] as $size => $properties) {
      // Make the image handle
      $handle = $this->image->make($image->getRealPath());

      // Set the directory for this media type
      $filePath = public_path($this->mediaConfiguration['path']);

      // Check that the directory exists, if not attempt to create it
      if ($this->checkDirectoryExists($filePath, true) == false)
      {
        throw new \Exception('Directory "'. $filePath .'" does not exist, or could not be created.');
      }

      // Try to fix any orientation issues
      $handle->orientate();

      // Copy the original
      if ($size == 'original')
      {
        $handle->save($filePath . DIRECTORY_SEPARATOR . $newFileName, 100);
      }
      // Are we cropping the image AND keeping the same aspect ratio?
      elseif (isset($properties['crop']) and $properties['crop'] == true and isset($properties['maintainRatio']) and $properties['maintainRatio'] == true)
      {
        $handle->fit($properties['width'], $properties['height'])->save($filePath . DIRECTORY_SEPARATOR . $newFileName, $properties['quality']);
      }
      // Are we just cropping the image?
      elseif (isset($properties['crop']) and $properties['crop'] == true)
      {
        $handle->crop($properties['width'], $properties['height'], false)->save($filePath . DIRECTORY_SEPARATOR . $newFileName, $properties['quality']);
      }
      // Bog standard resize
      else
      {
        $handle->resize($properties['width'], $properties['height'], function ($constraint) {
          $constraint->aspectRatio();
        })->save($filePath . DIRECTORY_SEPARATOR . $newFileName, $properties['quality']);
      }
    }

    // Finally return the image name
    return $newFileName;
  }

  /**
   * Delete all images (based in the array of image types/sizes)
   *
   * @param string $image - the filename
   *
   */
  public function delete($image)
  {

  }

  /**
   * Checks for the existence of a specified directory and optionally create it if not
   *
   * @param $directory
   * @param $createIfMissing
   *
   * @return bool
   */
  protected function checkDirectoryExists($directory, $createIfMissing = false)
  {
    // Check the directory exists
    $exists = $this->filesystem->exists($directory);

    // If it doesn't exist and we want to automagically create the directory...
    if ($exists == false && $createIfMissing == true)
    {
      // Make the directory
      $this->filesystem->mkdir($directory);

      return true;
    }

    // Return if the directory exists or not
    return $exists;
  }

  /**
   * Returns the file name for the new image
   *
   * @param UploadedFile $image  The uploaded file
   *
   * @return string  The file name to use for the new images
   */
  protected function generateFileName(UploadedFile $image)
  {
    // Do we want to retain the original filename?
    if ($this->retainOriginalFilename == true)
    {
      // Return the original filename
      return $image->getClientOriginalName;
    }


    // Return a psudo random string
    return str_random('15');
  }

}