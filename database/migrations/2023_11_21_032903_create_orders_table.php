<?php

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('gross_amount', 20, 2);
            $table->enum('status', ['Unpaid', 'Paid']);
            $table->dateTime('paid_at')->nullable();
            $table->string('courir');
            $table->string('courir_type');
            $table->decimal('courir_price', 20, 2);
            $table->foreignIdFor(UserAddress::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
