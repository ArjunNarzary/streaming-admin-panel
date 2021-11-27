<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->bigInteger('distributor_id');
            $table->text('description');
            $table->string('language');
            $table->integer('length');
            $table->date('release_date');
            $table->decimal('revenue')->nullable();
            $table->decimal('budget')->nullable();
            $table->integer('type')->comment('1 = Long Movie, 2 = Short Movie');
            $table->boolean('premium_status')->comment('0 = Free, 1 = subcription, 2 = rental ');
            $table->double('amount', 10, 2);
            $table->string('banner')->default('default.jpg');
            $table->string('link')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('movies');
    }
}
