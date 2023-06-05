<?php

namespace App\Http\Schemas;

/**
 * @OA\Schema(
 *     title="Product",
 *     description="Modelo de Produto",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Nome do Produto"),
 *     @OA\Property(property="price", type="number", example=10.99),
 *     @OA\Property(property="description", type="string", example="Descrição do Produto"),
 *     @OA\Property(property="category", type="string", example="Categoria do Produto"),
 *     @OA\Property(property="image_url", type="string", example="https://exemplo.com/produto.jpg"),
 * )
 */
class ProductSchema
{
}
