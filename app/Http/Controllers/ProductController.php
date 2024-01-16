<?php

namespace App\Http\Controllers;

use App\Models\Shop\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $name = $request->query('name');

        $query = Product::with('brand', 'categories', 'comments');

        // If a name is provided, filter results (returns all if no name is searched)
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        $products = $query->get();

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'featured' => 'required|boolean',
            'is_visible' => 'required|boolean',
            'backorder' => 'required|boolean',
            'requires_shipping' => 'required|boolean',
            'published_at' => 'required|date',
            'shop_brand_id' => 'required|exists:shop_brands,id',
            'shop_categories' => 'array',
            'shop_categories.*' => 'exists:shop_categories,id',
        ]);

        // Creating a new product
        $product = Product::create(Arr::except($validatedData, ['shop_categories']));

        // Attaching categories to the product
        if (!empty($validatedData['categories'])) {
            $product->categories()->sync($validatedData['shop_categories']);
        }

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
