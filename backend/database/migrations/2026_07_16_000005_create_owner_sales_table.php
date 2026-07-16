<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owner_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('invoice_number')->unique();
            $table->string('customer_name')->nullable();
            $table->unsignedInteger('items_count')->default(0);
            $table->decimal('total', 12, 2);
            $table->string('payment_method');
            $table->string('status')->default('Completed');
            $table->timestamp('sold_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owner_sales');
    }
};
