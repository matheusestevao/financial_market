<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HgbrazilService
{
    public function getInfo(string|array $symbol)
    {
        return Http::hgbrazil()
                ->get('', [
                    'key' => env('HGBRAZIL_KEY'),
                    'symbol' => $symbol
                ])
                ->throw()
                ->json();
    }
}