<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owner_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('plan');
            $table->string('status')->default('Active');
            $table->decimal('price', 12, 2);
            $table->date('renews_at');
            $table->unsignedInteger('user_limit')->nullable();
            $table->unsignedInteger('product_limit')->nullable();
            $table->unsignedInteger('transaction_limit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owner_subscriptions');
    }
};
