<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_code');
            $table->string('event_name');
            $table->integer('user_id');
            $table->integer('field_id');
            $table->boolean('calculate_ld');
            $table->double('avg_drive',8,2)->nullable();
            $table->double('long_drive',8,2)->nullable();
            $table->enum('teeing_ground', ['black', 'blue','white','red']);
            $table->integer('max_player');
            $table->longText('description');
            $table->mediumText('short_description');
            $table->string('poster')->nullable();
            $table->enum('event_type', ['tournament', 'gameday']);
            $table->enum('status', ['open', 'inprogress','closed','finished']);
            $table->enum('hole_type', [18, 19,1018]);
            $table->dateTimeTz('kick_off');
            $table->dateTimeTz('deadline_register');
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
        Schema::dropIfExists('events');
    }
}