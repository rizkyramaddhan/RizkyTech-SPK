<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bom;
use App\Models\Product;
use App\Models\BomItem;
use App\Models\Material;

class BomController extends Controller
{
    public function index()
    {
        return response()->json(Bom::with('product', 'items.material')->get());
    }

    public function show($id)
    {
        return response()->json(Bom::with('product', 'items.material')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'version' => 'required',
            'note' => 'nullable',
            'active' => 'boolean',
            'items' => 'required|array',
        ]);

        $bom = Bom::create([
            'product_id' => $data['product_id'],
            'version' => $data['version'],
            'note' => $data['note'] ?? null,
            'active' => $data['active'] ?? true,
        ]);

        foreach ($data['items'] as $item) {
            BomItem::create([
                'bom_id' => $bom->id,
                'material_id' => $item['material_id'],
                'qty' => $item['qty'],
                'uom' => $item['uom'] ?? 'pcs',
            ]);
        }

        return response()->json($bom->load('items.material'));
    }

    public function update(Request $request, $id)
    {
        $bom = Bom::findOrFail($id);

        $data = $request->validate([
            'version' => 'sometimes',
            'note' => 'nullable',
            'active' => 'nullable|boolean',
        ]);

        $bom->update($data);
        return response()->json($bom);
    }

    public function destroy($id)
    {
        Bom::findOrFail($id)->delete();
        return response()->json(['message' => 'BOM deleted']);
    }
}
