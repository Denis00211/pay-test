<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->uuid('uuid')->index()->unique();
            $table->unsignedDecimal('amount', 10);
            $table->unsignedTinyInteger('status');
            $table->dateTime('created_date');
            $table->dateTime('payment_date')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('card_first_six', 6)->nullable();
            $table->string('card_last_four', 4)->nullable();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
}
