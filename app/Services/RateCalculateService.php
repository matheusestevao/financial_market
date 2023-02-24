<?php

namespace App\Services;

use App\Models\Category;

class RateCalculateService
{
    protected $brApiService;

    public function __construct(
        BrApiService $brApiService
    )
    {
        $this->brApiService = $brApiService;
    }

    public function setDay()
    {
        $day = date('N', strtotime(date('Y-m-d')));

        switch ($day) {
            case 1:
            case 7:
                return false;
                break;
            
            default:
                return $day;
                break;
        }
    }

    public function setFIRF()
    {
        $category = Category::where('type', 'FIRF')->first();

        return $category;
    }

    public function leapYear()
    {
        $leap = date('L', mktime(0, 0, 0, 1, 1, date('Y')));

        if($leap) {
            return 262;
        }

        return 261;
    }

    public function rateCalculate(object $wallets)
    {
        $baseCalcule = date('d/m/Y', strtotime(date('Y-m-d') . '-01 day'));

        $primeRate = $this->brApiService->prime_rate(
            'brazil', false, $baseCalcule, $baseCalcule
        );
        
        $days = $this->leapYear();

        $rate = $primeRate['prime-rate'][0]['value'] / 100;

        $rateDay = number_format((1+$rate) ** (1/$days)-1, 4, '.');

        foreach ($wallets as $wallet) {
            $wallet->amount = ((1+$rateDay) * ($wallet->amount / 100)) * 100;
            $wallet->save();
        }
    }
}