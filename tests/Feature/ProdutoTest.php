<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Produto;
use App\Models\User;

class ProdutoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Configuração inicial para os testes de integração.
     * Cria o token que irá chamar os métodos e anexa aos headers das requisições
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Cria um usuário válido usando a factory
        $user = User::factory()->create();

        // Autentica o usuário e obtém o token JWT
        $jwtAuth = app('tymon.jwt.auth');
        $token = $jwtAuth->fromUser($user);

        // Define o token JWT nos cabeçalhos das solicitações
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ]);
    }

    /**
     * Testa o endpoint para listar todos os produtos.
     *
     * @return void
     */
    public function testListarProdutos()
    {
        // Cria alguns produtos no banco de dados
        Produto::factory()->count(5)->create();

        // Faz a requisição para o endpoint de listagem
        $response = $this->get('/api/produtos');

        // Verifica se a resposta tem o código de status 200 (OK)
        $response->assertStatus(200);
        // $response->assertStatus(302);

        // Verifica se a resposta contém um array de produtos com dados minimos
        $response->assertJsonStructure([
            '*' => [
                'id',
                'nome',
            ]
        ]);
    }

    /**
     * Testa o endpoint para buscar um produto específico.
     *
     * @return void
     */
    public function testBuscarProduto()
    {
        // Cria produto no banco de dados
        $produto = Produto::factory()->count(1)->create()->first();

        // Faz a requisição para o endpoint de busca com parametro
        $response = $this->get('/api/produtos/' . $produto->id);

        // Verifica se a resposta tem o código de status 200 (OK)
        $response->assertStatus(200);

        // Verifica se a resposta contém os dados minimos do produto
        $response->assertJson([
            'id' => $produto->id,
            'nome' => $produto->nome,
        ]);
    }
    /**
     * Testa o endpoint para buscar um produto inexistente por ID.
     *
     * @return void
     */
    public function testBuscarProdutoInexistente()
    {
        // Faz a requisição para o endpoint de busca com um ID inexistente
        $response = $this->get('/api/produtos/99999999990000000000000009999999999999990000'); // <= é um ID inexistente

        // Verifica se a resposta tem o código de status 404 (Not Found)
        $response->assertStatus(404);

        // Verifica se a resposta contém a mensagem de erro
        $response->assertJson([
            'message' => 'Produto não encontrado',
        ]);
    }

}
