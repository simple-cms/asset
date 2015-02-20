<?php

use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('media_files', function($table)
    {
      $table->increments('id');
      $table->string('slug', 80)->unique();
      $table->string('meta_title', 70);
      $table->string('meta_description', 155);
      $table->string('title', 100);
      $table->text('excerpt');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('media_files');
  }

}
