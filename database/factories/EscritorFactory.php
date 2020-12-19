<?php

/*
|--------------------------------------------------------------------------
| Cart Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Escritor\Models\Cart::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'entity_id' => 1,
        'entity_type' => \Escritor\Models\Product::class,
        'product_variants' => '',
        'address' => '',
        'quantity' => 1,
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
    ];
});


/*
|--------------------------------------------------------------------------
| Order Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Escritor\Models\Order::class, function (Faker\Generator $faker) {
    return [
        'uuid' => 'foo-bar-foo-bar',
        'user_id' => 1,
        'transaction_id' => 999,
        'details' => $faker->paragraph().' '.$faker->paragraph(),
        'shipping_address' => json_encode([
            'address' => '21 Iceboat Terr',
            'city' => 'Toronto',
            'country' => 'Canada',
            'state' => 'Ontario',
        ]),
        'is_shipped' => false,
        'tracking_number' => null,
        'notes' => 'This is a test order duh',
        'status' => 'pending',
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
    ];
});


/*
|--------------------------------------------------------------------------
| Product Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Escritor\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => 'dumb',
        'url' => 'dumb',
        'code' => 'a98s7d9',
        'price' => 9999,
        'weight' => 0,
        'width' => '9',
        'height' => '11',
        'depth' => '8',
        'discount' => 0,
        'discount_type' => '',
        'stock' => 1,
        'is_available' => 1,
        'is_published' => 1,
        'is_featured' => 0,
        'is_download' => 1,
        'file' => '',
        'hero_image' => '',
        'seo_keywords' => 'dumb is dumb',
        'seo_description' => 'dumb is dumb',
        'details' => $faker->paragraph().' '.$faker->paragraph(),
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
    ];
});

/*
|--------------------------------------------------------------------------
| Product Variant Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Escritor\Models\Variant::class, function (Faker\Generator $faker) {
    return [
        'product_id' => 1,
        'key' => 'Size',
        'value' => 'small|medium|large(+2)[+2]',
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
    ];
});

/*
|--------------------------------------------------------------------------
| Transaction Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Escritor\Models\Transaction::class, function (Faker\Generator $faker) {
    return [
        'uuid' => 'foo-bar-foo-bar',
        'user_id' => 1,
        'provider' => 'sitecpayment',
        'state' => 'success',
        'subtotal' => 99.99,
        'tax' => 0,
        'total' => 109.99,
        'shipping' => 10.00,
        'refund_date' => null,
        'refund_requested' => false,
        'provider_id' => 'foo-bar-999',
        'provider_date' => 20160930,
        'provider_dispute' => null,
        'notes' => null,
        'cart' => json_encode([[
            'price' => 19.00,
            'quantity' => 1,
            'name' => 'StarWars',
        ]]),
        'response' => json_encode(['message' => 'success']),
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
    ];
});


/*
|--------------------------------------------------------------------------
| Coupon Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Escritor\Models\Coupon::class, function (Faker\Generator $faker) {
    return [
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
        'start_date' => $faker->datetime(),
        'end_date' => $faker->datetime(),
        'code' => 'coupon-A',
        'currency' => 'usd',
        'discount_type' => 'dollar',
        'amount' => 5,
        'limit' => 1,
        'sitecpayment_id' => 'coupon-A',
    ];
});


/*
|--------------------------------------------------------------------------
| Subscription Plans Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Escritor\Models\Plan::class, function (Faker\Generator $faker) {
    return [
        'name' => 'cheap hosting',
        'uuid' => \Illuminate\Support\Str::random(20),
        'amount' => 9999,
        'interval' => 'monthly',
        'currency' => 'usd',
        'enabled' => true,
        'sitecpayment_name' => 'cheap-package',
        'trial_days' => 30,
        'subscription_name' => 'default',
        'descriptor' => 'dumb is dumb',
        'description' => $faker->paragraph().' '.$faker->paragraph(),
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),

    ];
});
