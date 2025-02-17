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
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->foreignId('biller_id');
            $table->date('date');
            $table->date('date_due')->nullable();
            $table->string('type');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('currency', 10)->default('USD');
            $table->text('description');
            $table->string('reference', 20);
            $table->integer('count')->default(0);
            $table->text('attachments');
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
