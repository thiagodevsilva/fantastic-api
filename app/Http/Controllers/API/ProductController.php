<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *     title="API de Produtos",
 *     version="1.0.0",
 *     description="API para gerenciamento de produtos",
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/produtos",
     *      summary="Exibe uma listagem de todos itens da tabela",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Tabela produtos",
     *      ),
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        // pega todos produtos da tabela e retorna eles em um JSON
        $produtos = Produto::all();
        return response()->json($produtos);
    }

    /**
     * @OA\Get(
     *      path="/api/produtos/{id}",
     *      summary="Busca um item pelo seu ID",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID do produto",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Item encontrado com sucesso",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Item não encontrado",
     *      ),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // busca pelo ID
        $produto = Produto::find($id);
        if (!$produto) {
            // caso não localize
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }
        // retorna o JSON do produto
        return response()->json($produto);
    }

}
