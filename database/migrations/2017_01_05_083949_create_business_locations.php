<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessLocations extends Migration
{
    /**
     * Business locations migration .
     *
     * @return void
     */


    public function up()
    {
        Schema::create('business_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('postal_code');
            $table->text('pictures')->nullable();


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
        Schema::dropIfExists('business_locations');
    }
}
