<?php

namespace App\Console\Commands;

use App\Models\UserWallet;
use App\Services\RateCalculateService;
use Illuminate\Console\Command;

class DailyIncomeCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily_income:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate return on fixed income investments';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        RateCalculateService $rateCalculateService
    )
    {
        $date = $rateCalculateService->setDay();
        
        if($date) {
            $category = $rateCalculateService->setFIRF();

            $wallets = UserWallet::where("category_id", $category->id)->get();

            if($wallets->count()) {
                $rateCalculateService->rateCalculate($wallets);
            }
        }
    }
}
