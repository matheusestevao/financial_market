<?php

namespace App\Services;

use App\Models\UserWallet;
use Illuminate\Support\Facades\Log;

class UserWalletService
{
    public function validate(
        string $user_id,
        string $ticker,
        int $amount,
    ): bool
    {
        $validate = UserWallet::where('user_id', $user_id)
                                ->where('ticker', $ticker)
                                ->first();

        if(empty($validate) || $validate->amount < $amount) {
            return false;
        } else {
            return true;
        }
    }

    public function store(
        string $user_id,
        string $type_transaction_id,
        string $type_transaction,
        string $category_id,
        string $ticker,
        int $amount
    )
    {   
        $params = array_filter(get_defined_vars());

        $wallet = UserWallet::where('user_id', $user_id)
                            ->where('ticker', $ticker)
                            ->first();

        switch (ucfirst(strtolower($params['type_transaction']))) {
            case 'Buy':
            case 'Dock':
                unset($params['type_transaction']);

                if(empty($wallet)) {
                    UserWallet::create($params);

                    break;
                }

                $wallet->amount = $wallet->amount + $amount;
                $wallet->save();

                break;
            
            case 'Sell':
            case 'Rescue':
                $wallet->amount = $wallet->amount - $amount;
                $wallet->save();

                if(!$wallet->amount) {
                    $wallet->delete();
                }

                break;
        }
    }
}