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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('line_research');
            $table->string('abstract');
            $table->foreignId('state_id')->nullable();
            $table->string('problem_statement');
            $table->string('justification');
            $table->string('background');
            $table->string('technical_manager_experience');
            $table->string('capcities');
            $table->string('general_objective');
            $table->string('specific_objective');
            $table->string('expected_results');
            $table->string('expected_results_review');
            $table->string('differentiators');
            $table->string('benefits');
            $table->string('products_generated');
            $table->string('ownership_proposal');
            $table->foreignId('announcement_id')->nullable();
            $table->foreignId('area_knowledge_id')->nullable();
            $table->foreignId('user_id')->nullable();
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
        Schema::dropIfExists('proposals');
    }
};
