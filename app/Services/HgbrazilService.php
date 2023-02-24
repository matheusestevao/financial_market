<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HgbrazilService
{
    public function getInfo(string|array $symbol)
    {
        return Http::hgbrazil()
                ->get('', [
                    'key' => '9f4de14c',
                    'symbol' => $symbol
                ])
                ->throw()
                ->json();
    }
}