<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('announcements_id');
            $table->string('name');
            $table->date('date_start');
            $table->date('date_end');
            $table->timestamps();
            
            $table->foreign('announcements_id')->references('id')->on('announcements');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendar_announcements');
    }
};
