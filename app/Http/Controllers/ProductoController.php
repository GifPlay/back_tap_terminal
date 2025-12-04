<?php

namespace App\Http\Controllers;

use App\Exports\ProductosExport;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProductoController extends Controller
{
    public function index(){
        return $productos = Producto::all();
    }
    public function show($id)
    {
        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 204);
        }

        return response()->json($producto);
    }

    public function exportProductosExcel()
    {
        return Excel::download(new ProductosExport, 'productos.xlsx');
    }

    public function exportProductosPdf()
    {
        $productos = Producto::all();
        $pdf = Pdf::loadView('exporter.productos', compact('productos'));
        return $pdf->download('productos.pdf');
    }

    public function store(Request $request){
        $validator = $this->validarProducto($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors(),
            ], 205);
        }

        $producto = Producto::create([
            'producto' => $request->input('producto'),
            'marca' => $request->input('marca'),
            'precio' => $request->input('precio'),
            'created_at' => now()
        ]);
        return response()->json($producto, 201);
    }
    public function update(Request $request, $id)
    {
        $validator = $this->validarProducto($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors(),
            ], 205);
        }

        $producto = Producto::findOrFail($id);

        $producto->update([
            'producto'   => $request->producto,
            'marca'      => $request->marca,
            'precio'     => $request->precio,
            'updated_at' => now(),
        ]);

        return $producto;
    }

    public function validarProducto(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'producto' => 'required',
                'precio' => 'required|numeric|min:0|max:999',
                'marca' => 'required',
            ],
            [
                'producto.required' => 'Debes ingresar el nombre del producto.',
                'precio.required'   => 'El precio es obligatorio.',
                'precio.numeric'    => 'El precio debe ser numérico.',
                'precio.min'    => 'El precio debe ser mayor a 0.',
                'precio.max'    => 'El precio debe ser menor o igual a 999.',
                'marca.required'    => 'Debes ingresar la marca.',
            ]
        );
        return $validator;
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        if (!$producto) {
            return response()->json([
                'message' => 'Producto no encontrado, no es posible eliminarlo'
            ], 204);
        }

        $producto->delete();

        return response()->json(['message' => 'Producto eliminado']);
    }


}
