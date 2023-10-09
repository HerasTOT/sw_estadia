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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposals_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('state_id');

            $table->timestamps();
            
            $table->foreign('proposals_id')->references('id')->on('proposals');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('state_id')->references('id')->on('proposal_states');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
