<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends Controller
{
    public function index()
    {
        return response()->json(Material::all());
    }

    public function show($id)
    {
        return response()->json(Material::with('bomItems.bom.product')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku' => 'required|unique:materials',
            'name' => 'required',
            'uom' => 'nullable',
            'safety_stock' => 'nullable|integer',
            'lead_time_days' => 'nullable|integer',
            'notes' => 'nullable',
        ]);

        $material = Material::create($data);
        return response()->json($material);
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $data = $request->validate([
            'sku' => 'sometimes|unique:materials,sku,' . $id,
            'name' => 'sometimes',
            'uom' => 'nullable',
            'safety_stock' => 'nullable|integer',
            'lead_time_days' => 'nullable|integer',
            'notes' => 'nullable',
        ]);

        $material->update($data);
        return response()->json($material);
    }

    public function destroy($id)
    {
        Material::findOrFail($id)->delete();
        return response()->json(['message' => 'Material deleted']);
    }
}