<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BrApiService
{
    /**
     * $sortBy values => null | name | close | chane | change_abs | volume | market_cap_basic | sector
     * $sortOrder values => null | asc | desc
     */
    public function list(
        ?string $sortBy = null,
        ?string $sortOrder = null,
        int $limit = 1
    )
    {
        $params = array_filter(get_defined_vars());

        return Http::brapi()
                    ->get('quote/list', $params)
                    ->throw()
                    ->json();
    }

    /**
     * $ticker values => "ticker1" OR "ticker1, ticker2..."
     * $range values => 1d, 5d, 1mo, 3mo, 6mo, 1y, 2y, 5y, 10y, ytd, max
     * $interval values => 1d, 5d, 1mo, 3mo, 6mo, 1y, 2y, 5y, 10y, ytd, max
     * $fundamental values => true, false
     * $dividends => true, false
     */
    public function ticker(
        string $tickers,
        ?string $range = '1d',
        ?string $interval = '1d',
        ?bool $fundamental = true,
        ?bool $dividends = true
    )
    {
        $params = array_filter(get_defined_vars());
        
        return Http::brapi()
                    ->get('quote/' . $tickers, $params)
                    ->throw()
                    ->json();
    }

    public function prime_rate(
        ?string $country = null,
        ?bool $historical = null,
        ?string $start = null,
        ?string $end = null,
        ?string $sortBy = null,
        ?string $sortOrder = null
    )
    {
        $params = array_filter(get_defined_vars());
        
        return Http::brapi()
                    ->get('v2/prime-rate', $params)
                    ->throw()
                    ->json();
    }
}