<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Faker\Factory as Faker;

class DetalleVentaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');
        $ventas = Venta::all();
        $productos = Producto::all();

        foreach ($ventas as $venta) {
            $detalleTotal = 0;
            $items = $productos->random(rand(1, 3));

            foreach ($items as $producto) {
                $cantidad = rand(1, 5);
                $precioUnitario = $faker->randomFloat(2, 50, 500);
                $subtotal = $cantidad * $precioUnitario;

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                ]);

                $detalleTotal += $subtotal;
            }

            $venta->update(['total' => $detalleTotal]);
        }
    }
}
