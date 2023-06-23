<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o endpoint para realizar o login do usuário.
     *
     * @return void
     */
    public function testLogin()
    {
        // Cria um usuário no banco de dados
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Faz a requisição para o endpoint de login
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Verifica se a resposta tem o código de status 200 (OK)
        $response->assertStatus(200);

        // Verifica se a resposta contém os dados do token de acesso
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }

    /**
     * Testa o endpoint para realizar o login do usuário com credenciais inválidas.
     *
     * @return void
     */
    public function testLoginCredenciaisInvalidas()
    {
        // Faz a requisição para o endpoint de login com credenciais inválidas
        $response = $this->postJson('/api/login', [
            'email' => 'email_invalido@example.com',
            'password' => 'senha_invalida',
        ]);

        // Verifica se a resposta tem o código de status 401 (Unauthorized)
        $response->assertStatus(401);

        // Verifica se a resposta contém a mensagem de erro
        $response->assertJson([
            'error' => 'Unauthorized',
        ]);
    }


    /**
     * Testa o endpoint para realizar o logout do usuário.
     *
     * @return void
     */
    public function testLogout()
    {
        // Cria um usuário no banco de dados
        $user = User::factory()->create();

        // Autentica o usuário
        $token = auth('api')->login($user);

        // Faz a requisição para o endpoint de logout
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/logout');

        // Verifica se a resposta tem o código de status 200 (OK)
        $response->assertStatus(200);

        // Verifica se a resposta contém a mensagem de sucesso
        $response->assertJson([
            'message' => 'Successfully logged out',
        ]);
    }
}
