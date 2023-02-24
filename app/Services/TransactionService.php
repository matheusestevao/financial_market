<?php

namespace App\Services;

use App\Models\Category;
use App\Models\TransactionHistory;
use App\Models\TypeTransaction;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    public function getCategory(string $category): object
    {
        return Category::where('type', $category)->first();
    }

    public function getTypeTransaction(string $typeTransaction): object
    {
        return TypeTransaction::where('name', $typeTransaction)->first();
    }

    public function store(
        string $user_id,
        string $type_transaction_id,
        string $category_id,
        string $ticker,
        int $amount,
        int $value
    )
    {
        $params = array_filter(get_defined_vars());
        
        try {
            TransactionHistory::create($params);

            return response()->json([
                'message' => 'Transaction Save'
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getFile(). ' - ' . $th->getLine() . ' - ' .print_r($th->getMessage(), 1));

            return response()->json([
                'message' => 'Error Save Transaction'
            ], 404);
        }
    }
}