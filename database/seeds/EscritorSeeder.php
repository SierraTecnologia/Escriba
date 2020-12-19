<?php

use Illuminate\Database\Seeder;

class EscritorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(Escritor\Models\Plan::class, rand(1, 5))->create();
		factory(Escritor\Models\Coupon::class, rand(1, 5))->create();
		factory(Escritor\Models\Transaction::class, rand(1, 50))->create();
		factory(Escritor\Models\Variant::class, rand(1, 5))->create();
		factory(Escritor\Models\Product::class, rand(1, 5))->create();
		factory(Escritor\Models\Order::class, rand(1, 50))->create();
		factory(Escritor\Models\Cart::class, rand(1, 50))->create();
    }
}
