<?php

namespace App\Http\Controllers;

use App\Models\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductImageController extends Controller
{
    public function uploadImage(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg|max:10240', // must be a jpg and 10MB Max
        ]);

        $image = $request->file('image');

        // Using Spatie Media Library for associating the image with the product
        $product->addMedia($image)
            ->toMediaCollection('product-images');

        return Response::json(['message' => 'Image uploaded successfully']);
    }
}

