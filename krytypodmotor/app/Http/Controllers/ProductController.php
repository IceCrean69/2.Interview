<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Material;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'material']);

        // Filtrování
        if ($request -> has('brand')) {
            $query -> where('brand_id', $request->brand);
        }
        if ($request -> has('material')) {
            $query -> where('material_id', $request->material);
        }

        // Řazení
        $sort = $request -> get('sort', 'name');
        $direction = $request -> get('direction', 'asc');
        $query -> orderBy($sort, $direction);

        // Stránkování
        $products = $query -> paginate(10);

        $brands = Brand :: all();
        $materials = Material :: all();

        return view('products.index', compact('products', 'brands', 'materials', 'sort', 'direction'));
    }

    public function edit(Product $product)
    {
        $brands = Brand :: all();
        $materials = Material :: all();
        return view('products.edit', compact('product', 'brands', 'materials'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'material_id' => 'required|exists:materials,id',
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product -> update($validatedData);

        return redirect() -> route('products.index') -> with('success', 'Produkt byl úspěšně aktualizován.');
    }

    public function export(Request $request)
    {
        $query = Product :: with(['brand', 'material']);

        // Aplikujeme stejné filtrování a řazení jako při zobrazení
        if ($request -> has('brand')) {
            $query -> where('brand_id', $request->brand);
        } 
        
        if ($request -> has('material')) {
            $query -> where('material_id', $request->material);
        }

        $sort = $request -> get('sort', 'name');
        $direction = $request -> get('direction', 'asc');
        $query -> orderBy($sort, $direction);

        $products = $query -> get();

        $csvFileName = 'products.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Kód', 'Název', 'Značka', 'Materiál', 'Cena', 'Popis');

        $callback = function() use ($products, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($products as $product) {
                fputcsv($file, array(
                    $product -> code,
                    $product -> name,
                    $product -> brand->name,
                    $product -> material->name,
                    $product -> price,
                    $product -> description
                ));
            }
            fclose($file);
        };

        return response() -> stream($callback, 200, $headers);
    }
}