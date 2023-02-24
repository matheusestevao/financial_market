<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function store_transaction_with_middleware(): void
    {
        $data = [
            "category" => "FII",
            "type_transaction" => "SELL",
            "ticker" => "BPFF11",
            "value" => 7.81,
            "amount" => 1
        ];

        $response = $this->post('/api/transaction/store', $data);
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    public function store_transaction(): void
    {
        $data = [
            "category" => "FII",
            "type_transaction" => "SELL",
            "ticker" => "BPFF11",
            "value" => 7.81,
            "amount" => 1
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/transaction/store', $data);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Transaction Save!"]);
        $response->assertJson(['data' => $data]);
    }
}
