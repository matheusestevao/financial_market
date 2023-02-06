<?php

/**
 * Configuration file to access B3 API
 */

return [
    'url' => env('HGBRAZIL_URL', 'https://api.hgbrasil.com/finance/stock_price'),
    'type' => env('HGBRAZIL_TYPE', 'free'),
    'key' => env('HGBRAZIL_KEY')
];