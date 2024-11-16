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
        Schema::create('peformance_sheet', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->nullable();
            $table->timestamp('from')->nullable();
            $table->timestamp('to')->nullable();
            $table->string('class')->nullable();
            $table->string('week')->nullable();
            
            $table->text('social_behavior')->nullable();
            $table->text('personal_habits')->nullable();

            $table->text('act_kindness')->nullable();
            $table->text('notebook')->nullable();
            $table->integer('total')->nullable();

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
        Schema::dropIfExists('peformance_sheet');
    }
};
