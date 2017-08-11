<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class Books extends Migration {
	/**
	 * Run the migrations.
	 * CREATE TABLE `books` (
	 * `id` int(11) NOT NULL AUTO_INCREMENT,
	 * `users_id` int(11) DEFAULT NULL,
	 * `author` varchar(245) DEFAULT NULL,
	 * `title` varchar(245) DEFAULT NULL,
	 * `publication_date` date DEFAULT NULL,
	 * `order` int(11) DEFAULT NULL,
	 * PRIMARY KEY (`id`)
	 * ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
	 *
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'books', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer('users_id');
			$table->string ( 'author' );
			$table->string ( 'title' );
			$table->date ('publication_date');
			$table->integer('order')->index();
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'books' );
	}
}
