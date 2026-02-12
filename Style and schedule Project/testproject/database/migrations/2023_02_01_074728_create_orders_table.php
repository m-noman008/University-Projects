<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->unsignedBigInteger('order_number');
            $table->string('payment_type')->nullable();
            $table->integer('gateway_id')->nullable();
            $table->text('shipping')->nullable();
            $table->tinyInteger('status')->comment('0 => pending, 1 => completed');
            $table->tinyInteger('stage')->default(0)->comment('0 => pending, 1 => processing, 2 => on_shipping, 3 => ship, 4 => completed, 5 => cancel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
