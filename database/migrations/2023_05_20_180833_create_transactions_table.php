<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trans_id');
            $table->string('trans_user_id');
            $table->string('trans_plaid_trans_id');
            $table->string('trans_plaid_categories');
            $table->float('trans_plaid_amount');
            $table->string('trans_plaid_category_id');
            $table->date('trans_plaid_date');
            $table->string('trans_plaid_name');
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
        Schema::dropIfExists('transactions');
    }
}
