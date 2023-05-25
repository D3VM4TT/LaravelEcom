<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //         price, category_id, image
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('price')->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->string('image')->nullable();

            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'price',
                'category_id',
                'image'
            ]);
        });
    }
}
