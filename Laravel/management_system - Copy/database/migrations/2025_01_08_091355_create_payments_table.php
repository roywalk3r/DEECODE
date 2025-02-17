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
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('invoice_id');
            $table->integer('number');
            $table->date('date');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('method', 20)->default('cash');
            $table->text('details');
            $table->text('credit_card')->nullable();
            $table->string('token')->nullable();
            $table->string('status', 50)->default('released');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
