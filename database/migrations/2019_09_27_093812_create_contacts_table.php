<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contractor_id')->unsigned();
            $table->foreign('contractor_id')->references('id')->on('contractors');
            $table->string('name', 100);
            $table->unique('name');
            $table->string('mobile_number', 20);
            $table->unique('mobile_number');
            $table->string('email', 50);
            $table->unique('email');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('contacts');
    }
}
