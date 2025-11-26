<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::with('boms.items.material')->get());
    }

    public function show($id)
    {
        return response()->json(Product::with('boms.items.material')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku' => 'required|unique:products',
            'name' => 'required',
            'description' => 'nullable',
            'type' => 'nullable',
            'lead_time_days' => 'nullable|integer',
            'cycle_time_minutes' => 'nullable|integer',
        ]);

        $product = Product::create($data);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'sku' => 'sometimes|unique:products,sku,' . $id,
            'name' => 'sometimes',
            'description' => 'nullable',
            'type' => 'nullable',
            'lead_time_days' => 'nullable|integer',
            'cycle_time_minutes' => 'nullable|integer',
        ]);

        $product->update($data);
        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}
