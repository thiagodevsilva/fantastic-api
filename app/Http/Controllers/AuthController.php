<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Realiza o login do usuário",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string"),
     *             @OA\Property(property="expires_in", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        // Obtém as credenciais (e-mail e senha) da requisição
        $credentials = $request->only('email', 'password');

        // Verifica se as credenciais são válidas e autentica o usuário
        if (!$token = auth('api')->attempt($credentials)) {
            // Retorna uma resposta de erro caso as credenciais sejam inválidas
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Retorna uma resposta de sucesso com o token de acesso
        return $this->respondWithToken($token);
    }

    /**
     * @OA\Delete(
     *     path="/api/logout",
     *     summary="Realiza o logout do usuário",
     *     @OA\Parameter(
     *         name="token",
     *         in="query",
     *         description="Token de autenticação",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        // Efetua o logout do usuário
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
        ]);
    }

}
