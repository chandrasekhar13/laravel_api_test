<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class TransactionHelper
{
    public static function calcTransAfterBalance()
    {
        $transactions = [];
        $initial_balance = 5; //as given in the question, considering $5 as inital balance
        $result = DB::table('transactions')
            ->select(DB::raw('DATE(trans_plaid_date) as transaction_date'), DB::raw('ROUND(SUM(trans_plaid_amount),2)as paid_amount'))
            ->groupBy('transaction_date')
            ->orderBy('transaction_date', 'ASC')
            ->get();
        foreach ($result as $transaction) {

            $closing_balance = round($initial_balance - $transaction->paid_amount, 2);
            $transactions['transactions_after_balance'][] = array($transaction->transaction_date => $closing_balance);
            $initial_balance = $closing_balance;
        }
        return $transactions;
    }
    public static function calcAvgBalance()
    {
        $result = self::calcTransAfterBalance();

        $total_days = count($result['transactions_after_balance']);
        $total_sum = 0;
        foreach ($result['transactions_after_balance'] as $balance) {
            foreach ($balance as $date => $closing_balance) {
                $total_sum += $closing_balance;
            }
        }
        $avg_closing_balance = $total_sum / $total_days;
        return $avg_closing_balance;

    }
    public static function getFirstAndLast30DaysAvgClosingBalance()
    {

        $result = self::calcTransAfterBalance();

        //first 30 days avg balance calculation
        $first30DaysBalance = array_slice($result['transactions_after_balance'], 0, 30);
        $total_sum = 0;
        foreach ($first30DaysBalance as $closing_balance) {
            foreach ($closing_balance as $key => $value) {
                $total_sum += $value;
            }

        }
        $first30DaysAvgBalance = round(($total_sum / 30), 2);

        //last 30 days avg balance calculation
        $last30DaysBalance = array_slice($result['transactions_after_balance'], -30);

        $total_sum2 = 0;
        foreach ($last30DaysBalance as $last_closing_balance) {
            foreach ($last_closing_balance as $key => $value) {
                $total_sum2 += $value;
            }

        }
        $last30DaysAvgBalance = round(($total_sum2 / 30), 2);
        return ['first_30_days_avg_balance' => $first30DaysAvgBalance, 'last_30_days_avg_balance' => $last30DaysAvgBalance];

    }
    public static function getOtherResults()
    {

        //Calculate last 30 days income except 18020004 this category id

        $result = DB::select('SELECT SUM(trans_plaid_amount) as total_income from transactions t3 where trans_plaid_date IN (SELECT * FROM (SELECT distinct DATE(trans_plaid_date) as transaction_date FROM transactions t1 order by transaction_date desc limit 30) t2) and trans_plaid_category_id != 18020004 and trans_plaid_amount < 0 order by trans_plaid_date desc');

        //Calculate debit transaction count in 30 days
        $result2 = DB::select('SELECT COUNT(trans_plaid_amount) as debit_count from transactions t3 where trans_plaid_date IN (SELECT * FROM (SELECT distinct DATE(trans_plaid_date) as transaction_date FROM transactions t1 order by transaction_date desc limit 30) t2) and  trans_plaid_amount > 0 order by trans_plaid_date desc');

        //Sum of debit trans amount done on Friday/Saturday/Sunday

        $result3 = DB::select('SELECT SUM(trans_plaid_amount) as debit_sum from transactions where WEEKDAY(trans_plaid_date) in (4,5,6)  and  trans_plaid_amount > 0 order by trans_plaid_date asc');

        //Sum of income  with transaction amount  > 15
        $result4 = DB::select('SELECT SUM(trans_plaid_amount) as transaction_amt from transactions where trans_plaid_amount > 15 order by trans_plaid_date asc');

        return ['last_30_days_income' => round($result[0]->total_income, 2), 'debit_count' => $result2[0]->debit_count, 'debit_sum' => round($result3[0]->debit_sum, 2), 'transaction_sum_income' => round($result4[0]->transaction_amt, 2)];
    }
}
