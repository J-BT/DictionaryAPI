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
        Schema::create('wordreference_history', function (Blueprint $table) {
            $table->id();
            $table->string("category");
            $table->string("languageFrom");
            $table->string("languageTo");
            $table->string("search");
            $table->string("result")->nullable;
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
        Schema::dropIfExists('wordreference_history');
    }
};
