<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(Schema::hasTable("user_addresses")==false){
        Schema::create("user_addresses",function(Blueprint $table){
            $table->bigIncrements("id");
            $table->bigInteger("user_id");
            $table->string("line1")->nullable();
            $table->string("line2")->nullable();
            $table->string("city")->nullable();
            $table->string("country")->nullable();
            $table->string("postal_code")->nullable();
            $table->string("state")->nullable();
        });//''
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists("user_addresses");
    }
}
