<?php

namespace App\Http\Controllers;

use App\Models\Shop\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
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

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Customer $customer
     * @return JsonResponse
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return JsonResponse
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}
