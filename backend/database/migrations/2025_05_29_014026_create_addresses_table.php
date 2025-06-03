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
        
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable(false);
            $table->integer('number')->nullable(false);
            $table->string('neighborhood')->nullable(false);
            $table->string('complement')->nullable();
            $table->string('city')->nullable(false);
            $table->string('state', 2)->nullable(false);
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
        Schema::dropIfExists('address');
    }
};
