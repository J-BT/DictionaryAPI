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
        Schema::create('jisho_histories', function (Blueprint $table) {
            $table->id()->unique();
            $table->string("category");
            $table->string("languageFrom");
            $table->string("languageTo");
            $table->string("search");
            $table->integer("searchCount")->nullable;
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
        Schema::dropIfExists('jisho_histories');
    }
};
