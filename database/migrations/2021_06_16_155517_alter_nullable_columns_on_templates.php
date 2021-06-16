<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNullableColumnsOnTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credit_card_templates', function (Blueprint $table) {
            $table->string('last_4')->nullable()->change();
        });

        Schema::table('vehicle_templates', function (Blueprint $table) {
            $table->string('mileage')->nullable()->change();
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
