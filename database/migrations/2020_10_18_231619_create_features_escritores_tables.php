<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeaturesEscritoresTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // @todo
        // Schema::create(config('siravel.db-prefix', '').'product_variants', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('product_id')->default(0);
        //     $table->string('key');
        //     $table->string('value');
            
        //     $table->timestamps();
        // });
        // Schema::create(config('siravel.db-prefix', '').'cart', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id');
        //     $table->integer('entity_id');
        //     $table->string('entity_type');
        //     $table->text('product_variants')->nullable();
        //     $table->text('address')->nullable();
        //     $table->integer('quantity');
            
        //     $table->timestamps();
        // });
        // Schema::create(config('siravel.db-prefix', '').'transactions', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('uuid');
        //     $table->integer('user_id');
        //     $table->string('provider');
        //     $table->string('provider_id');
        //     $table->string('provider_date');
        //     $table->text('provider_dispute')->nullable();
        //     $table->string('state');
        //     $table->text('coupon')->nullable();
        //     $table->integer('subtotal');
        //     $table->integer('tax');
        //     $table->integer('total');
        //     $table->integer('shipping');
        //     $table->datetime('refund_date')->nullable();
        //     $table->boolean('refund_requested')->default(0);
        //     $table->text('cart');
        //     $table->text('response');
        //     $table->text('notes')->nullable();
            
        //     $table->timestamps();
        // });
        // Schema::create(config('siravel.db-prefix', '').'orders', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('uuid');
        //     $table->integer('user_id');
        //     $table->integer('transaction_id');
        //     $table->text('details');
        //     $table->text('shipping_address')->nullable();
        //     $table->boolean('is_shipped')->default(0);
        //     $table->string('tracking_number')->nullable();
        //     $table->text('notes')->nullable();
        //     $table->string('status')->default('pending');
            
        //     $table->timestamps();
        // });
        // Schema::table('user_meta', function ($table) {
        //     $table->string('sitecpayment_id')->nullable();
        //     $table->string('card_brand')->nullable();
        //     $table->string('card_last_four')->nullable();
        //     $table->text('shipping_address')->nullable();
        //     $table->text('billing_address')->nullable();
        // });
        // Schema::create(config('siravel.db-prefix', '').'plans', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('amount');
        //     $table->string('interval');
        //     $table->string('name');
        //     $table->string('uuid');
        //     $table->string('currency');
        //     $table->string('descriptor')->nullable();
        //     $table->integer('trial_days')->default(0);
        //     $table->string('sitecpayment_name');
        //     $table->string('subscription_name')->nullable();
        //     $table->text('description')->nullable();
        //     $table->boolean('enabled')->default(false);
        //     $table->boolean('is_featured')->default(false);
            
        //     $table->timestamps();
        // });
        // Schema::create(config('siravel.db-prefix', '').'favorites', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('product_id');
        //     $table->integer('user_id');
            
        //     $table->timestamps();
        // });
        // Schema::create(config('siravel.db-prefix', '').'coupons', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->date('start_date');
        //     $table->date('end_date')->nullable();
        //     $table->string('code');
        //     $table->string('currency');
        //     $table->string('discount_type')->default('dollar');
        //     $table->integer('amount')->default(0);
        //     $table->integer('limit')->default(1);
        //     $table->string('sitecpayment_id');
        //     $table->boolean('for_subscriptions')->default(false);
            
        //     $table->timestamps();
        // });
        // Schema::create(config('siravel.db-prefix', '').'order_items', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('order_id');
        //     $table->integer('product_id');
        //     $table->integer('transaction_id');
        //     $table->integer('refund_id')->nullable();
        //     $table->integer('quantity');
        //     $table->json('variants')->nullable();
        //     $table->decimal('subtotal');
        //     $table->boolean('was_refunded')->default(false);
        //     $table->decimal('tax');
        //     $table->decimal('total');
        //     $table->integer('shipping');
        //     $table->string('status')->default('pending');
            
        //     $table->timestamps();
        // });
        // Schema::create(config('siravel.db-prefix', '').'refunds', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('transaction_id')->default(0);
        //     $table->string('provider_id');
        //     $table->string('uuid');
        //     $table->string('provider')->default('sitecpayment');
        //     $table->decimal('amount')->default(0);
        //     $table->string('charge');
        //     $table->string('currency');
            
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::drop(config('siravel.db-prefix', '').'refunds');
        // Schema::drop(config('siravel.db-prefix', '').'order_items');
        // Schema::drop(config('siravel.db-prefix', '').'coupons');
        // Schema::drop(config('siravel.db-prefix', '').'favorites');
        // Schema::drop(config('siravel.db-prefix', '').'plans');
        // // Schema::table(config('siravel.db-prefix', '').'user_meta', function ($table) {
        // //     $table->dropColumn('sitecpayment_id');
        // //     $table->dropColumn('card_brand');
        // //     $table->dropColumn('card_last_four');
        // //     $table->dropColumn('shipping_address');
        // //     $table->dropColumn('billing_address');
        // // });
        // Schema::drop(config('siravel.db-prefix', '').'orders');
        // Schema::drop(config('siravel.db-prefix', '').'transactions');
        // Schema::drop(config('siravel.db-prefix', '').'cart');
        // Schema::drop(config('siravel.db-prefix', '').'product_variants');
        // Schema::drop(config('siravel.db-prefix', '').'products');
    }
}
