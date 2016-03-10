<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlashesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flashes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('classId');
			$table->boolean('hasNorm');
			$table->boolean('hasBS');
			$table->string('flashPath');
			$table->string('flashPathBS');
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
		Schema::drop('flashes');
	}

}
