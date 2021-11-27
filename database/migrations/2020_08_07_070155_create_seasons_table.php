i<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('series_id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->integer('season_no');
            $table->bigInteger('distributor_id');
            $table->text('description');
            $table->tinyInteger('premium_type')->comment('0 = Free, 1 = subcription, 2 = rental ');
            $table->double('amount', 10, 2);
            $table->integer('total_episodes')->nullable();
            $table->date('release_date');
            $table->decimal('revenue', 10, 2)->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('cover')->default('default.jpg');
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
        Schema::dropIfExists('seasons');
    }
}
