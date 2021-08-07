<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesColumn extends Migration
{
    public $tables = [
        'childcare',
        'credit_cards',
        'education',
        'entertainment',
        'food',
        'gift',
        'housing',
        'loans',
        'medical',
        'miscellaneous',
        'personal',
        'shopping',
        'subscriptions',
        'tax',
        'travel',
        'utilities',
        'vehicles'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->text('notes')->nullable();
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
        foreach ($this->tables as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->dropColumn('notes');
            });
        }
    }
}
