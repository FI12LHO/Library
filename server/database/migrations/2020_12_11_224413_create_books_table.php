<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table -> id();
            $table -> string('id_user');
            $table -> string('title', 255);
            $table -> string('author', 255);
            $table -> string('publishing_company', 255);
            $table -> string('publishing_date', 255);
            $table -> integer('num_pages');
            $table -> text('review');
            $table -> timestamps();
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
