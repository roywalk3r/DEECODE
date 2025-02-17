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
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->string('reference', 50)->nullable();
            $table->string('category');
            $table->date('date');
            $table->date('date_due')->nullable();
            $table->string('status', 50)->default('unpaid');
            $table->decimal('amount', 25, 4)->default(0.0000);
            $table->integer('tax_id')->nullable();
            $table->boolean('tax_type')->default(0);
            $table->decimal('tax_value', 25, 4)->default(0.0000);
            $table->decimal('tax_total', 25, 4)->default(0.0000);
            $table->decimal('total', 25, 4)->default(0.0000);
            $table->decimal('total_due', 25, 4)->default(0.0000);
            $table->string('payment_method');
            $table->date('payment_date')->nullable();
            $table->text('details');
            $table->text('attachments');
            $table->foreignId('supplier_id')->nullable();
            $table->string('currency', 10)->default('USD');
            $table->foreignId('user_id')->nullable();
            $table->enum('approval_status', ["denied","approved","waiting"])->default('waiting for approval');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
