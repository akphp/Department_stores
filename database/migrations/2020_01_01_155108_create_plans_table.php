<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->float('price_month');
            $table->float('price_year');
            $table->unsignedBigInteger('currency_id');
            $table->integer('plan_level');
            $table->integer('no_featured_items');
            $table->integer('no_sales_transaction');
            $table->integer('no_emp');
            $table->integer('no_item');
            $table->string('description');
            $table->tinyInteger('is_active')->comment("0 => inactive , 1 => active");
            $table->integer('is_trial');
            $table->integer('interval_trail');
            $table->integer('no_transactions');
            $table->float('percent_price_sales_transaction');
            $table->float('total_price_sales');
            $table->tinyInteger('details_reports')->comment("0 => inactive , 1 => active");
            $table->tinyInteger('is_support')->comment("0 => inactive , 1 => active");
            $table->tinyInteger('is_mix_store')->comment("0 => inactive , 1 => active");
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
