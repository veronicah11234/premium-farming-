<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
            ->constrained('orders')
            ->cascadeOnDelete();
                  $table->string('tracking_number')->nullable();
            $table->string('courier')->nullable();
            $table->string('status')->default('pending'); // pending, out_for_delivery, delivered
            $table->timestamp('delivered_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
