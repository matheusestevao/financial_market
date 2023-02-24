<?php

namespace Database\Seeders;

use App\Models\TypeTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeTransactionTableSeeder extends Seeder
{
    protected $typeTransactions = [
        'Buy',
        'Sell',
        'Dock',
        'Rescue'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->typeTransactions as $typeTransacation) {
            TypeTransaction::create([
                'name' => $typeTransacation
            ]);
        }
    }
}
