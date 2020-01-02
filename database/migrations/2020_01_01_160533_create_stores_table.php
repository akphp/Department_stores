<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('store_name');
            $table->dateTime('store_start_date');
            $table->string('store_logo');
            $table->integer('store_size');
            $table->integer('store_inventory_no');
            $table->integer('store_employee_no');
            $table->string('store_notes');
            $table->integer('store_business_record_no');
            $table->integer('store_tax_no');
            $table->integer('store_type_activity');
            $table->integer('store_product_type');
            $table->integer('store_city_id');
            $table->string('store_address');
            $table->string('store_address_map');
            $table->string('store_mobil');
            $table->string('store_fax');
            $table->string('store_email');
            $table->string('store_owner');
            $table->integer('store_timezone');
            $table->integer('store_languange');
            $table->integer('store_cuurency');
            $table->dateTime('date_create_account');
            $table->integer('store_active_flag');
            $table->string('custom_url');
            $table->rememberToken();
            $table->string('date_format');
            $table->string('country_service');
            $table->unsignedBigInteger('plan_id');

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
        Schema::dropIfExists('stores');
    }
}
