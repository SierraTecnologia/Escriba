<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create(config('app.db-prefix', '').'user_meta', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                $table->string('phone')->nullable();

                $table->boolean('is_active')->default(false);
                $table->string('activation_token')->nullable();

                $table->boolean('escritoring')->default(0);
                $table->boolean('terms_and_cond')->default(1);

                $table->timestamps();
            });
            //code...
        } catch (\Throwable $th) {
            try {
                Schema::create(config('app.db-prefix', '').'user_meta', function (Blueprint $table) {
                    $table->increments('id');

                    $table->integer('user_id')->unsigned();

                    $table->string('phone')->nullable();

                    $table->boolean('is_active')->default(false);
                    $table->string('activation_token')->nullable();

                    $table->boolean('escritoring')->default(0);
                    $table->boolean('terms_and_cond')->default(1);

                    $table->timestamps();
                });
            } catch (\Throwable $th) {
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_meta');
    }
}
