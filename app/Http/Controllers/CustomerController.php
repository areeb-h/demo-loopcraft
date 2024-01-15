<?php

namespace App\Http\Controllers;

use App\Models\Shop\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->query('name');

        $query = Customer::query();

        // If a name is provided, filter results (returns all if no name is searched)
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        $customers = $query->get();

        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:shop_customers,email',
            'phone' => 'required|string|regex:/^\+?\d{10,15}$/',
            'birthday' => 'required|date_format:Y-m-d\TH:i:s.u\Z',
            'gender' => 'required|string|max:7',
        ]);

        $customer = Customer::create($validatedData);

        return response()->json($customer, 201);
    }

    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'string
            |max:255',
            'email' => 'email|unique:shop_customers,email,' . $customer->id,
        ]);

        $customer->update($validatedData);

        return response()->json($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}
