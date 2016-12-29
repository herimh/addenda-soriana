<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addendas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provider_code', 15);
            $table->string('invoice', 20)->nullable();
            $table->string('consecutive', 100)->default(0);
            $table->integer('money_type');
            $table->integer('package_type');
            $table->integer('package_quantity');
            $table->integer('delivery_place');
            $table->integer('store_code');
            $table->date('delivery_date');
            $table->string('delivery_folio', 100)->nullable();
            $table->string('cite', 100)->nullable();
            $table->string('purchase_order', 100)->nullable();
            $table->string('cfdi_file', 150)->nullable();
            $table->string('addenda_file', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
