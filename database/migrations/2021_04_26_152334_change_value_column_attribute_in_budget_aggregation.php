<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeValueColumnAttributeInBudgetAggregation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_aggregation', function (Blueprint $table) {
            $table->enum('type', ['spent', 'saved', 'earned'])->change();
            $table->string('value')->default('0.00')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_aggregation', function (Blueprint $table) {
            $table->string('value')->change();
            $table->string('type')->change();
        });
    }
}
