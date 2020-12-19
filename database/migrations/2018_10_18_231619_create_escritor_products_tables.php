<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEscritorProductsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable(config('siravel.db-prefix', '').'products')) { // && ! Schema::hasColumn(config('siravel.db-prefix', '').'products', 'business_code')) {
            Schema::create(config('siravel.db-prefix', '').'products', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('url')->nullable();
                $table->string('code')->nullable();
                $table->decimal('price')->nullable();
                $table->string('weight')->nullable();
                $table->string('width')->nullable();
                $table->string('height')->nullable();
                $table->string('depth')->nullable();
                $table->decimal('discount')->default(0);
                $table->string('hero_image')->nullable();
                $table->string('notification')->nullable();
                $table->string('discount_type')->nullable();
                $table->date('discount_start_date')->nullable();
                $table->date('discount_end_date')->nullable();
                $table->integer('stock')->default(0);
                $table->boolean('is_available')->default(false);
                $table->boolean('is_published')->default(false);
                $table->boolean('is_download')->default(false);
                $table->boolean('is_featured')->default(false);
                $table->string('file')->nullable();
                $table->string('seo_description')->nullable();
                $table->string('seo_keywords')->nullable();
                $table->text('details')->nullable();

                // Criei pro jaedelivery
                $table->integer('category_id')->nullable();
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(config('siravel.db-prefix', '').'refunds');
        Schema::drop(config('siravel.db-prefix', '').'order_items');
        Schema::drop(config('siravel.db-prefix', '').'coupons');
        Schema::drop(config('siravel.db-prefix', '').'favorites');
        Schema::drop(config('siravel.db-prefix', '').'plans');
        // Schema::table(config('siravel.db-prefix', '').'user_meta', function ($table) {
        //     $table->dropColumn('sitecpayment_id');
        //     $table->dropColumn('card_brand');
        //     $table->dropColumn('card_last_four');
        //     $table->dropColumn('shipping_address');
        //     $table->dropColumn('billing_address');
        // });
        Schema::drop(config('siravel.db-prefix', '').'orders');
        Schema::drop(config('siravel.db-prefix', '').'transactions');
        Schema::drop(config('siravel.db-prefix', '').'cart');
        Schema::drop(config('siravel.db-prefix', '').'product_variants');
        Schema::drop(config('siravel.db-prefix', '').'products');
    }
}
