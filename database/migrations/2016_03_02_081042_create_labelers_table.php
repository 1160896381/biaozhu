<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabelersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('labelers', function(Blueprint $table)
		{
			$table->softDeletes();
			$table->increments('id');
			$table->string('labelerName');
			$table->integer('userId');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('salt');
			$table->string('verify');
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
		Schema::drop('labelers');
	}

}
