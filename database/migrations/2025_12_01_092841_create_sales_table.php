<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique();
            $table->foreignId('store_id')->nullable()->constrained('stores')->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->decimal('subtotal',12,2)->default(0);
            $table->decimal('tax',12,2)->default(0);
            $table->decimal('total',12,2)->default(0);
            $table->string('payment_method')->nullable(); // cash, mpesa, card, transfer
            $table->foreignId('served_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('sold_at')->nullable();
            $table->timestamps();

            $table->index(['receipt_number','sold_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
