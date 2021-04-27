<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSandSavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sand_saves', function (Blueprint $table) {
            $table->id();
            $table->integer('score_id');
            for ($i = 1; $i <= 18; $i++) {
                $table->boolean("sand_save_hole_".$i)->default(null)->nullable();
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
        Schema::dropIfExists('sand_saves');
    }
}
