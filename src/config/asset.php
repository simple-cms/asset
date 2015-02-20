<?php

return [
  // Root Asset URL - example.com/<assetURL>
  'assetURL' => 'asset',

  // Setup our Glide configuration
  // For more see glide.thephpleague.com
  'glideConfiguration' => [
    'source' => public_path() .'/assets/images',
    'cache' => storage_path() . '/framework/cache/images',
    'max_image_size' => 150*150,
    'base_url' => '/asset/',
    'driver' => 'gd',
  ],

];
