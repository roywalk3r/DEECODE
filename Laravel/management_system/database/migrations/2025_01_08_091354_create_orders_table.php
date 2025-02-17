<?php

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
            $table->increments('id');
            $table->foreignId('user_id');
            $table->string('name')->nullable();
            $table->string('phone_number', 20);
            $table->text('order_details');
            $table->integer('qty');
            $table->date('date');
            $table->enum('status', ["pending","out"])->default('pending');
            $table->decimal('amount', 10, 2);
            $table->integer('total_amount');
            $table->enum('company', ["chopbox","chopbox_plus"]);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
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
