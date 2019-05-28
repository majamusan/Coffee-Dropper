<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('postcode');

            $table->string('open_Monday')->nullable();
            $table->string('open_Tuesday')->nullable();
            $table->string('open_Wednesday')->nullable();
            $table->string('open_Thursday')->nullable();
            $table->string('open_Friday')->nullable();
            $table->string('open_Saturday')->nullable();
            $table->string('open_Sunday')->nullable();
            $table->string('closed_Monday')->nullable();
            $table->string('closed_Tuesday')->nullable();
            $table->string('closed_Wednesday')->nullable();
            $table->string('closed_Thursday')->nullable();
            $table->string('closed_Friday')->nullable();
            $table->string('closed_Saturday')->nullable();
            $table->string('closed_Sunday')->nullable();

            $table->decimal('lng', 10, 7);
            $table->decimal('lat', 10, 7);

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
        Schema::dropIfExists('locations');
    }
}
