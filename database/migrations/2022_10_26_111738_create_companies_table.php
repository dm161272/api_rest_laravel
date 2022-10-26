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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('website');
            $table->string('name')->nullable();
            $table->date('founded')->nullable();
            $table->string('size');
            $table->string('locality')->nullable();
            $table->string('region')->nullable();
            $table->string('country')->nullable();
            $table->string('industry')->nullable();
            $table->string('linkedin_url');
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
        Schema::dropIfExists('companies');
    }
};
