<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
			$table->string('uuid')->nullable();
            $table->integer('property_type_id')->nullable()->default(0);
            $table->string('county')->nullable();
            $table->string('country')->nullable();
            $table->string('town')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->text('image_full')->nullable();
            $table->text('image_thumbnail')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('num_bedrooms')->nullable()->default(0);
            $table->integer('num_bathrooms')->nullable()->default(0);
            $table->decimal('price', 12, 2)->nullable()->default(0);
            $table->string('type')->nullable()->default(0);
            //$table->dateTime('api_created_at')->nullable();
           // $table->dateTime('api_updated_at')->nullable();
            $table->text('property_type')->nullable();
			
			$table->enum('created_from', ['local','live'])->default('local');
			
			$table->string('postcode')->nullable();
			
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
        Schema::dropIfExists('properties');
    }
}
