<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaAttachmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::create('media_attachments', function($table)
    {
      $table->engine = 'InnoDB';
      $table->integer('media_id');
      $table->integer('media_attachment_id');
      $table->string('media_attachment_type');
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
		Schema::dropIfExists('media_attachments');
	}

}
