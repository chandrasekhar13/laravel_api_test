<?php

namespace App\Http\Controllers;

use App\Helpers\TransactionHelper;

class TransactionController extends Controller
{
    public function getTransactionAfterBalance()
    {
        $result = [];

        // call transaction helper which contains logical code for calculation of transaction after balance
        $result = TransactionHelper::calcTransAfterBalance();
        return response()->json($result);
    }

    public function calcAvgBalance()
    {
        // call transaction helper which calculates average closing balance
        $result = round(TransactionHelper::calcAvgBalance(), 2);
        return response()->json(['avg_closing_balance' => $result]);

    }
    public function firstLastAvgBalance()
    {
        $result = TransactionHelper::getFirstAndLast30DaysAvgClosingBalance();
        return response()->json($result);
    }
    public function otherConditions()
    {
        $result = TransactionHelper::getOtherResults();
        return response()->json($result);
    }
}
