<?php

/**
 * Areeb Hussain
 */

namespace Tests\Feature;

use App\Models\Shop\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use DatabaseTransactions;
    // use RefreshDatabase;

    // Test listing customers.
    public function test_list_customers()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->get('/api/customers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'birthday',
                    'gender',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    // Test searching for a customer.
    public function test_search_customer_by_name()
    {
        Sanctum::actingAs(User::factory()->create());

        // Searching for 'Kertzmann'
        $response = $this->getJson('/api/customers?name=Kertzmann');

        $response->assertJsonMissing(['name' => 'Searching for a user that does not exist']);

        $response->assertStatus(200)
            ->assertJsonCount(1);
    }

    // Test creating a new customer.
    public function test_create_customer()
    {
        Sanctum::actingAs(User::factory()->create());

        $customerData = [
            'name' => 'Test Customer',
            'email' => 'testcustomer@example.com',
            'phone' => '+9609948882',
            'birthday' => '1989-05-01T00:00:00.000000Z',
            'gender' => 'male',
        ];

        $response = $this->post('/api/customers', $customerData);

        $response->assertStatus(201)
            ->assertJson($customerData);
    }

    // Test updating a customer
    public function test_update_customer()
    {
        Sanctum::actingAs(User::factory()->create());

        $customer = Customer::factory()->create([
            'name' => 'Test Customer',
            'email' => 'testcustomer@example.com',
            'phone' => '+9609948882',
            'birthday' => '1989-05-01T00:00:00.000000Z',
            'gender' => 'Male',
        ]);

        $updateData = [
            'name' => 'Test Customer Modified',
        ];

        $response = $this->put("/api/customers/{$customer->id}", $updateData);


        $response->assertStatus(200)
            ->assertJson($updateData);

        $this->assertDatabaseHas('shop_customers', [
            'id' => $customer->id,
            'name' => 'Test Customer Modified'
        ]);

    }

    // Test deleting a customer.
    public function test_delete_customer()
    {
        Sanctum::actingAs(User::factory()->create());

        $customer = Customer::first();

        $response = $this->delete("/api/customers/{$customer->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('shop_customers', ['id' => $customer->id]);
    }
}
