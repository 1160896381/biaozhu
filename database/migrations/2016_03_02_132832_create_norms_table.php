<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNormsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('norms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('flashId');
			$table->integer('userId');
			$table->string('zeroLevel');
			$table->text('firstLevel');
			$table->text('secondLevel');
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
		Schema::drop('norms');
	}

}
