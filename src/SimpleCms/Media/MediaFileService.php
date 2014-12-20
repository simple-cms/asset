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

  // Retain original file names

  /**
   * DO we want to retain original filenames
   *
   * @var bool
   */
  protected $retainOriginalFilename;

  public function __construct(Image $image, Filesystem $filesystem)
  {
    $this->image = $image;
    $this->filesystem = $filesystem;
    $this->retainOriginalFilename = Config::get('media::retainOriginalFilename');
    $this->newFilenameLength =Config::get('media::newFilenameLength');
  }

  public function resize(UploadedFile $image)
  {
    // Set the name we want to use for the new image(s)
    $newFileName = $this->generateFileName($image) . '.' . $image->guessExtension();

    // Loop through each of the image sizes
    foreach ($this->mediaTypes[$type]['sizes'] as $size => $properties) {
      // Make the image handle
      $handle = $this->image->make($image->getRealPath());

      // Set the directory for this media type
      $filePath = public_path($this->mediaTypes[$type]['directory']) . DIRECTORY_SEPARATOR . $size;

      // Check that the directory exists
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
    // Loop through all possible media types
    foreach ($this->mediaTypes as $mediaType)
    {
      // Loop through each of the image sizes
      foreach ($mediaType['sizes'] as $size => $properties)
      {
        // Remove the file
        $this->filesystem->remove(public_path($mediaType['directory']) . DIRECTORY_SEPARATOR . $size . DIRECTORY_SEPARATOR . $image);
      }
    }
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
    // Do we want to refine the original filename?
    if ($this->retainOriginalFilename == true)
    {
      // Return the original filename
      return $image->getClientOriginalName;
    }


    // Return a psudo random string
    return str_random('15');
  }

}