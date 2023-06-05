<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        $category = $request->input('category');
        $hasImage = $request->input('has_image');
    
        $query = Product::query();
    
        if ($name) {
            $query->where('name', 'like', "%$name%");
        }
    
        if ($category) {
            $query->where('category', 'like', "%$category%");
        }
    
        if ($hasImage === 'true') {
            $query->whereNotNull('image_url');
        } elseif ($hasImage === 'false') {
            $query->whereNull('image_url');
        }
    
        $products = $query->get();
    
        return response()->json($products);
    }
    


    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'category' => 'required',
            'image_url' => 'url',
        ]);

        $product = Product::create($validatedData);
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'category' => 'required',
            'image_url' => 'url',
        ]);

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $product->update($validatedData);
        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Produto excluído com sucesso']);
    }
}
