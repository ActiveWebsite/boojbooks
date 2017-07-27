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
			$table->softDeletes(); # ALLOWS THE POSSIBILITY OF IMPLEMENTING A TRASH BIN
			
            $table->increments('id');
			$table->integer('user_id')->unsigned();
            $table->string('title');
            $table->string('author');
            $table->smallInteger('position')->unsigned();
            $table->char('isbn13',13)->nullable();
            $table->date('publication_date')->nullable();
            $table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			
			#$table->unique(['user','isbn13']); XXX SHOULD ISBN BE OPTIONAL OR REQUIRED AND UNIQUE?
			$table->unique(['user_id','title','author']);
			
			$table->index('user_id');
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
        \Storage::deleteDirectory('public/covers/');
    }
}
