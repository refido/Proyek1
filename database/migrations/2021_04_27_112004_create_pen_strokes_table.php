<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenStrokesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pen_strokes', function (Blueprint $table) {
            $table->id();
            $table->integer('score_id');
            for ($i = 1; $i <= 18; $i++) {
                $table->integer("pen_stroke_hole_".$i)->default(null)->nullable();
            }
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
        Schema::dropIfExists('pen_strokes');
    }
}
