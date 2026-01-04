<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('product_code')->unique();
            $table->string('brand');
            $table->string('model');
            $table->string('cpu')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->string('gpu')->nullable();
            $table->string('display')->nullable();
            $table->string('color')->nullable();
            $table->string('condition')->default('New');
            $table->string('warranty')->nullable();
            $table->string('country')->nullable();
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
