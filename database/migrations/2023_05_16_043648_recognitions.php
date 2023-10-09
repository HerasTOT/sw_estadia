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
        Schema::create('recognitions', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('code');
            $table->unsignedBigInteger('announcements_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('proposal_id');
            $table->timestamps();
            $table->foreign('announcements_id')->references('id')->on('announcements');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('proposal_id')->references('id')->on('proposals');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recognitions');
    }
};
