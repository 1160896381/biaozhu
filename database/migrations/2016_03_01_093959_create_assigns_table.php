<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assigns', function(Blueprint $table)
		{
			$table->softDeletes();
			$table->increments('id');
			$table->integer('classId');
			$table->integer('userId');
			$table->string('title');
			$table->integer('claim');
			$table->integer('state')->nullable();
			$table->integer('state2')->nullable();
			$table->timestamp('finishTime')->nullable();
			$table->timestamp('deadTime')->nullable();
			$table->string('labeler')->nullable();
			$table->string('receiver')->nullable();
			$table->string('initXml');
			$table->string('xml');
			$table->string('content');
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
		Schema::drop('assigns');
	}

}
