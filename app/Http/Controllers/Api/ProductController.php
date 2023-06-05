<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Schemas\ProductSchemas;
use App\Http\Schemas\ProductRequestSchema;


class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Listar todos os produtos",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filtrar por nome",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Filtrar por categoria",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="has_image",
     *         in="query",
     *         description="Filtrar por presença de imagem (true/false)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"true", "false"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna a lista de produtos filtrados",
     *     )
     * )
     */
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

        $filteredProducts = $products->filter(function ($product) {
            return !empty($product->image_url);
        });

        return response()->json($filteredProducts);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Criar um novo produto",
     *     @OA\Response(
     *         response=201,
     *         description="Retorna o produto criado",
     *     ),
     *     @OA\Response(response=422, description="Erro de validação")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Obter detalhes de um produto",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do produto",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna os detalhes do produto",
     *     ),
     *     @OA\Response(response=404, description="Produto não encontrado")
     * )
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }
        return response()->json($product);
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Atualizar um produto",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do produto",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna o produto atualizado",
     *     ),
     *     @OA\Response(response=404, description="Produto não encontrado"),
     *     @OA\Response(response=422, description="Erro de validação")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Excluir um produto",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do produto",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Produto excluído com sucesso"),
     *     @OA\Response(response=404, description="Produto não encontrado")
     * )
     */
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
