<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = public_path() . '/transactions.php';
        include $file;

        foreach ($transaction as $key => $value) {

            DB::table('transactions')->insert([

                'trans_id' => $value['trans_id'],
                'trans_user_id' => $value['trans_user_id'],
                'trans_plaid_trans_id' => $value['trans_plaid_trans_id'],
                'trans_plaid_categories' => $value['trans_plaid_categories'],
                'trans_plaid_amount' => $value['trans_plaid_amount'],
                'trans_plaid_category_id' => $value['trans_plaid_category_id'],
                'trans_plaid_date' => $value['trans_plaid_date'],
                'trans_plaid_name' => $value['trans_plaid_name'],

                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),

            ]);
        }

    }
}
