<?php
// app/Http/Controllers/PPICDashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PPICDashboardController extends Controller
{
    public function index()
    {
        // contoh data. Ganti dengan query Eloquent Anda (Product::with('bom','stock')->get())
        $products = [
            [
                'id' => 1,
                'sku' => 'VGA-RTX-001',
                'name' => 'VGA Turbo X1',
                'stock' => 120,
                'min_stock' => 20,
                'bom' => [
                    ['part' => 'GPU Chip', 'qty' => 1],
                    ['part' => 'PCB', 'qty' => 1],
                    ['part' => 'Fan', 'qty' => 2],
                ],
            ],
            [
                'id' => 2,
                'sku' => 'CPU-X117',
                'name' => 'Processor X117',
                'stock' => 35,
                'min_stock' => 10,
                'bom' => [
                    ['part' => 'Die', 'qty' => 1],
                    ['part' => 'Heatspreader', 'qty' => 1],
                    ['part' => 'Pins', 'qty' => 1],
                ],
            ],
            // tambah data lain...
        ];

        return view('ppic.dashboard', compact('products'));
    }
}
