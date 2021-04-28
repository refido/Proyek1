<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->string('score_code');
            $table->string('event_code');
            $table->integer('user_id');
            for ($i = 1; $i <= 18; $i++) {
                $table->integer("score_hole_" . $i)->default(null)->nullable();
            }
            $table->enum('join_status', ['accepted', 'rejected', 'waiting'])->default('waiting');
            $table->enum('score_status', ['waiting', 'correct', 'false'])->nullable();
            $table->string('score_evidence')->nullable();
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
        Schema::dropIfExists('scores');
    }
}
