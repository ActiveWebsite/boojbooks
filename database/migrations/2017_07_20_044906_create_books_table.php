<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
			$table->softDeletes(); # XXX ALLOWS THE POSSIBILITY OF A TRASH BIN
			
            $table->increments('id');
			$table->integer('user')->unsigned();
            $table->string('title');
            $table->string('author');
            $table->smallInteger('position')->unsigned();
            $table->char('isbn13',13)->unsigned();
            $table->timestamps();
			
			$table->foreign('user')->references('id')->on('users')->onDelete('cascade');
			
			$table->unique(['user','position']);
			$table->unique(['user','isbn13']);
			$table->unique(['user','title','author']);
			
			$table->index('user');
			$table->index('author');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
