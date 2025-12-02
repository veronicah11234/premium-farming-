<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('business_name')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('terms')->nullable(); // credit terms or description
            $table->text('address')->nullable();
            $table->timestamps();

            $table->index(['business_name','contact_name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
