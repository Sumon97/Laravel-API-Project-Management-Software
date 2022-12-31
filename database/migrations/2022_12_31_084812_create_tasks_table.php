<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->mediumText('des')->nullable();
            $table->string('status')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('tasks');
        $table->dropForeign(['project_id']);
    }
};
