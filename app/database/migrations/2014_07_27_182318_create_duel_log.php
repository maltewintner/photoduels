<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDuelLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('duel_log', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('visitor_id')->unsigned();
			$table->integer('picture_id_won')->unsigned();
			$table->integer('picture_id_lost')->unsigned();
			$table->integer('rating_won')->unsigned();
			$table->integer('rating_lost')->unsigned();
			$table->softDeletes();
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
		Schema::drop('duel_log');
	}

}
