<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleItemsTable extends Migration
{
    public function up()
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('product_name');
            $table->decimal('price',12,2);
            $table->integer('quantity')->default(1);
            $table->decimal('line_total',12,2);
            $table->timestamps();

            $table->index(['sale_id','product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_items');
    }
}
