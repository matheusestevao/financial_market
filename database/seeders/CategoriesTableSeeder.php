<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    protected $categories = [
        'Ações' => null,
        'Fundos Imobiliarios' => 'FII',
        'Renda Fixa' => 'FIRF'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->categories as $key => $value) {
            Category::create([
                'type' => $value,
                'description' => $key
            ]);
        }
    }
}
