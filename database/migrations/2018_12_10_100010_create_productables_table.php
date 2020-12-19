<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'escritables', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('escrito_id')->nullable();
                // $table->foreign('escrit_id')->references('id')->on('escrits');
                $table->unsignedInteger('escritable_id');
                $table->string('escritable_type');
                $table->float('cost')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escritables');
    }
}
