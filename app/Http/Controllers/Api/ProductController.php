<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Filtrar por categoría
        if ($request->has('category') && $request->category !== 'Todas') {
            $query->where('category', $request->category);
        }

        // Buscar por nombre o descripción
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Ordenar
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price-asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price-desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->orderBy('name', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'category' => $product->category,
                'image' => $product->image ? asset('storage/' . $product->image) : null,
                'is_active' => $product->is_active,
            ];
        });

        return response()->json($products);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::where('is_active', true)->find($id);

        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'stock' => $product->stock,
            'category' => $product->category,
            'image' => $product->image ? asset('storage/' . $product->image) : null,
            'is_active' => $product->is_active,
        ]);
    }

    /**
     * Get featured products
     */
    public function featured()
    {
        $products = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'category' => $product->category,
                    'image' => $product->image ? asset('storage/' . $product->image) : null,
                ];
            });

        return response()->json($products);
    }
}
