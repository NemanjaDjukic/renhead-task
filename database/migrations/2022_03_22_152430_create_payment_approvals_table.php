<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_id')
                ->nullable();
            $table->unsignedBigInteger('travel_payment_id')
                ->nullable();
            $table->string('payment_type');
            $table->enum('status', [
                'APPROVED',
                'DISAPPROVED',
            ]);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('payment_id')
                ->references('id')
                ->on('payments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('travel_payment_id')
                ->references('id')
                ->on('travel_payments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_approvals');
    }
};
