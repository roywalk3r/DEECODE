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
        Schema::create('recurring_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('date');
            $table->date('next_date')->nullable();
            $table->string('type');
            $table->string('frequency', 10);
            $table->string('number');
            $table->integer('occurence');
            $table->string('status');
            $table->text('data');
            $table->foreignId('bill_to_id')->nullable();
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_invoices');
    }
};
