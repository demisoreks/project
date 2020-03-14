<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contractor_id')->unsigned();
            $table->foreign('contractor_id')->references('id')->on('contractors');
            $table->string('name', 100);
            $table->string('description', 1000);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status', 1);
            $table->double('budget', 10, 2);
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
        Schema::dropIfExists('projects');
    }
}
