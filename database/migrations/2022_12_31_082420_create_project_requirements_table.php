<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('project_requirements', function (Blueprint $table) {
            $table->id();
            $table->mediumText('des')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('project_requirements');
        $table->dropForeign(['project_id']);
    }
};
