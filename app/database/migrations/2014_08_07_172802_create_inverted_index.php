<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvertedIndex extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inverted_index', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('word_id')->unsigned();
			$table->integer('picture_id')->unsigned();
			$table->integer('count')->unsigned();
			$table->softDeletes();
			$table->timestamps();
			$table->unique(array('word_id', 'picture_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('inverted_index');
	}

}
