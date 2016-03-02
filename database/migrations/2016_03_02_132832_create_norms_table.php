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
			$table->integer('classId');
			$table->integer('flashId');
			$table->integer('userId');
			$table->string('zeroType');
			$table->string('zeroTask');
			$table->string('zeroPath');
			$table->string('zeroPathBS');
			$table->string('zeroLevel');
			$table->string('firstLevel');
			$table->string('secondLevel');
			$table->integer('hasNorm');
			$table->integer('hasBS');
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
