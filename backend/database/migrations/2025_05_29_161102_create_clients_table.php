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
        
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->date('birth_date')->nullable(false);
            $table->enum('person_type', ['F', 'J'])->nullable(false);
            $table->char('cpf_cnpj', 14)->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('phone')->nullable(false);
            $table->foreignId('address_id')
                  ->constrained('addresses')
                  ->onDelete('cascade');
            $table->foreignId('profession_id')
                  ->constrained('professions')
                  ->onDelete('cascade');
            $table->boolean('active')->nullable(false);
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
        Schema::dropIfExists('clients');
    }
};
