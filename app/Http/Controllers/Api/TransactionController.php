<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BrApiService;
use App\Services\HgbrazilService;
use App\Services\TransactionService;
use App\Services\UserWalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Validator;

class TransactionController extends Controller
{
    protected $hgbService;
    protected $brApiService;
    protected $validateTransaction = [
        'Sell',
        'Rescue'
    ];

    public function __construct(
        HgbrazilService $hgbService,
        BrApiService $brApiService
    )
    {
        $this->hgbService = $hgbService;
        $this->brApiService = $brApiService;
    }

    public function list(Request $request)
    {
        return $this->brApiService->list(... $request->all());
    }

    public function tickers(Request $request)
    {   
        return $this->brApiService->ticker($request->tickers, ... $request->except(['tickers']));
    }

    public function prime_rate(Request $request)
    {
        return $this->brApiService->prime_rate(... $request->all());
    }

    public function store(
        Request $request,
        TransactionService $service,
        UserWalletService $walletService
    )
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string',
            'type_transaction' => 'required|string',
            'ticker' => 'required|string',
            'amount' => 'required|int',
            'value' => 'required|numeric'
        ]);
   
        if($validator->fails()){
            return response()->json([
                'message' => 'Validation Error.',
                'data' => $validator->errors()
            ], 402);  
        }

        try {
            $category = $service->getCategory(ucfirst(strtolower($request->category)));
            $typeTransaction = $service->getTypeTransaction(ucfirst(strtolower($request->type_transaction)));

            $request->merge([
                'user_id' => Auth::user()->id,
                'category_id' => $category->id,
                'type_transaction_id' => $typeTransaction->id,
                'value' => $request->value * 100,
            ]);

            if(in_array($typeTransaction->name, $this->validateTransaction)) {
                $validate = $walletService->validate($request->user_id, $request->ticker, $request->amount);
            }
            
            if(!isset($validate) || $validate) {
                $service->store(... $request->except(['category', 'type_transaction']));
                $walletService->store(... $request->except(['category', 'value']));

                return response()->json([
                    'message' => 'Transaction Save'
                ], 201);
            }
                
            return response()->json([
                'message' => 'Operation not available. You do not own this stock in your wallet.'
            ], 204);
        } catch (\Throwable $th) {
            Log::error($th->getFile(). ' - ' . $th->getLine() . ' - ' .print_r($th->getMessage(), 1));
            
            return response()->json([
                'message' => 'Error Save Transaction'
            ], 400);
        }
    }
}
