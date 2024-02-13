<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_file', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('ext', 10)->nullable();
            $table->string('path')->nullable();
            $table->unsignedBigInteger('leaflet_id')->nullable();
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
        Schema::dropIfExists('m_file');
    }
}
