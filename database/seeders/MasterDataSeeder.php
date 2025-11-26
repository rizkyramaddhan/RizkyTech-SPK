<?php
// database/seeders/MasterDataSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\Product;
use App\Models\Bom;
use App\Models\BomItem;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // ----- Materials -----
        $materials = [
            ['sku' => 'MAT-GPU-CORE', 'name' => 'GPU Core (ASIC)', 'unit_of_measurement' => 'pcs', 'safety_stock' => 10, 'lead_time_days' => 14],
            ['sku' => 'MAT-VRAM-CHIP', 'name' => 'VRAM Chip 8GB', 'unit_of_measurement' => 'pcs', 'safety_stock' => 50, 'lead_time_days' => 21],
            ['sku' => 'MAT-PCB-VGA', 'name' => 'PCB VGA Board', 'unit_of_measurement' => 'pcs', 'safety_stock' => 30, 'lead_time_days' => 10],
            ['sku' => 'MAT-FAN', 'name' => 'Cooling Fan', 'unit_of_measurement' => 'pcs', 'safety_stock' => 100, 'lead_time_days' => 7],
            ['sku' => 'MAT-HEATSPREADER', 'name' => 'Heatsink / Heatspreader', 'unit_of_measurement' => 'pcs', 'safety_stock' => 40, 'lead_time_days' => 12],
            ['sku' => 'MAT-CPU-DIE', 'name' => 'CPU Die', 'unit_of_measurement' => 'pcs', 'safety_stock' => 20, 'lead_time_days' => 18],
            ['sku' => 'MAT-CPU-PKG', 'name' => 'CPU Package / Substrate', 'unit_of_measurement' => 'pcs', 'safety_stock' => 25, 'lead_time_days' => 14],
            ['sku' => 'MAT-THERMALPASTE', 'name' => 'Thermal Paste', 'unit_of_measurement' => 'tube', 'safety_stock' => 200, 'lead_time_days' => 5],
        ];

        foreach ($materials as $m) {
            Material::updateOrCreate(['sku' => $m['sku']], $m);
        }

        // ----- Products -----
        $products = [
            ['sku' => 'VGA-RTX-7000', 'name' => 'RizkyTech RTX 7000', 'description' => 'High-end VGA for gaming/workstation', 'type' => 'finished', 'lead_time_days' => 7, 'cycle_time_minutes' => 120],
            ['sku' => 'CPU-ZEN-9', 'name' => 'RizkyTech ZEN-9', 'description' => 'High-performance processor', 'type' => 'finished', 'lead_time_days' => 10, 'cycle_time_minutes' => 90]
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['sku' => $p['sku']], $p);
        }

        // ----- BOMs -----
        $vga = Product::where('sku', 'VGA-RTX-7000')->first();
        $cpu = Product::where('sku', 'CPU-ZEN-9')->first();

        // create BOM for VGA
        $bomVga = Bom::updateOrCreate(
            ['product_id' => $vga->id, 'version' => '1.0'],
            ['note' => 'BOM for RTX-7000 v1', 'active' => true]
        );

        // create BOM for CPU
        $bomCpu = Bom::updateOrCreate(
            ['product_id' => $cpu->id, 'version' => '1.0'],
            ['note' => 'BOM for ZEN-9 v1', 'active' => true]
        );

        // ----- BOM Items for VGA -----
        $itemsVga = [
            ['material_sku' => 'MAT-GPU-CORE', 'quantity' => 1],
            ['material_sku' => 'MAT-VRAM-CHIP', 'quantity' => 8],
            ['material_sku' => 'MAT-PCB-VGA', 'quantity' => 1],
            ['material_sku' => 'MAT-FAN', 'quantity' => 2],
            ['material_sku' => 'MAT-HEATSPREADER', 'quantity' => 1],
        ];

        foreach ($itemsVga as $it) {
            $material = Material::where('sku', $it['material_sku'])->first();
            if ($material) {
                BomItem::updateOrCreate(
                    ['bom_id' => $bomVga->id, 'material_id' => $material->id],
                    ['quantity' => $it['quantity'], 'unit_of_measurement' => $material->unit_of_measurement]
                );
            }
        }

        // ----- BOM Items for CPU -----
        $itemsCpu = [
            ['material_sku' => 'MAT-CPU-DIE', 'quantity' => 1],
            ['material_sku' => 'MAT-CPU-PKG', 'quantity' => 1],
            ['material_sku' => 'MAT-THERMALPASTE', 'quantity' => 1],
        ];

        foreach ($itemsCpu as $it) {
            $material = Material::where('sku', $it['material_sku'])->first();
            if ($material) {
                BomItem::updateOrCreate(
                    ['bom_id' => $bomCpu->id, 'material_id' => $material->id],
                    ['quantity' => $it['quantity'], 'unit_of_measurement' => $material->unit_of_measurement]
                );
            }
        }

        $this->command->info('MasterDataSeeder: materials, products, boms, and bom_items created.');
    }
}
