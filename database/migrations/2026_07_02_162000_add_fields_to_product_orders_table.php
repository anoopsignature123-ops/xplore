<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_orders', function (Blueprint $table) {
            $table->integer('tax_percentage')->default(0)->after('tax');
            $table->string('address_type')->nullable()->after('customer_email');
            $table->text('address')->nullable()->after('address_type');
            $table->string('city_name')->nullable()->after('address');
            $table->string('state_name')->nullable()->after('city_name');
            $table->string('pincode', 10)->nullable()->after('state_name'); 
        });
    }

    /**
     * Reverse the migrations.
     * 
     * @return void
     */
    public function down()
    {
        Schema::table('product_orders', function (Blueprint $table) {
            $table->dropColumn([
                'tax_percentage',
                'address_type',   
                'address', 
                'city_name',
                'state_name',
                'pincode'
            ]);
        });
    }
};
