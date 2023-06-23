<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->text('descricao');
            $table->decimal('valor', 8, 2);
            $table->timestamps();
        });

        DB::table('produtos')->insert([
            [
                'nome' => 'Produto 1',
                'descricao' => 'Descrição do Produto 1',
                'valor' => 99.99,
            ],
            [
                'nome' => 'Produto 2',
                'descricao' => 'Descrição do Produto 2',
                'valor' => 199.99,
            ],
            [
                'nome' => 'Produto 3',
                'descricao' => 'Descrição do Produto 3',
                'valor' => 149.99,
            ],
            [
                'nome' => 'Produto 4',
                'descricao' => 'Descrição do Produto 4',
                'valor' => 249.99,
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};
