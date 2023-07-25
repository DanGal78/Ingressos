<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\Evento;
use App\Models\Ingresso;
use App\Models\User;
use App\Models\Permissao;



class IngressosTest extends TestCase
{
    use RefreshDatabase;

    public const BASE_URL = "/api/ingressos";

    public function test_se_retorna_uma_lista_de_ingresso(){
        $this->cadastraIngresso();

        $respose = $this->get(self::BASE_URL, [
            "Accept" => "application/json"
        ]);
        $respose->assertOk();
    }

    public function test_se_retorna_401_quando_nao_autenticado(){

        $this->cadastraIngresso();

        $respose = $this->post(self::BASE_URL, [
            "lote" => "Lote teste",
            "inicio" => "2023-07-17",
            "fim" => "2023-07-25",
            "quantidade_disponivel" => 250,
            "preco" => 130.89,
            "evento_id" => 1,
        ], [
            "Accept" => "application/json"
        
        ]);

        $respose->assertUnauthorized();
    }
    public function test_se_retorna_403_quando_nao_possui_permissao(){
        $this->cadastraIngresso();

        $token = auth()->attempt([
            "email" => "email@email.com",
            "password" => "12345678",
        ]);

        $respose = $this->post(self::BASE_URL, [
            "lote" => "Lote teste",
            "inicio" => "2023-07-17",
            "fim" => "2023-07-25",
            "quantidade_disponivel" => 250,
            "preco" => 130.89,
            "evento_id" => 1,
        ], [
            "Accept" => "application/json",
            "Authorization" => "Bearer" . $token
        
        ]);

        $respose->assertForbidden();
    }

    public function test_cadastra_ingresso_corretamente(){
        $this->cadastraIngresso();
        $user = User::where("email", "email@email.com")->first();
        $role = Permissao::create([
            "nome" => "PROMOTOR"
        ]);
        $user->permissoes()->sync([$role->id]);
        $evento = Evento::all()->first();
        
        $token = auth()->attempt([
            "email" => "email@email.com",           
            "password" => "12345678"
        ]);

        $respose = $this->post(self::BASE_URL, [
            "lote" => "Lote teste",
            "inicio" => "2023-07-17",
            "fim" => "2023-07-25",
            "quantidade_disponivel" => 250,
            "preco" => 130.89,
            "evento_id" => $evento->id,
        ], [
            "Accept" => "application/json",
            "Authorization" => "Bearer" . $token
        
        ]);

        $respose->assertCreated();
    }


    private function cadastraIngresso() {

        $ingresso = Ingresso::find(1);

        if ($ingresso) {
            return;
        }
        $user = User::create([
            "name" => "Daniel Galdino",
            "email" => "email@email.com",
            "password" => Hash::make("12345678"),

        ]);
        
        $evento = Evento::create([
            "nome" => "Evento teste",
            "descricao" => "teste de ingrsso",
            "local" => "Pasta de teste",
            "data_evento" => "2023-01-01",
            "user_id" => $user->id,
            "slug" => "evento-teste"

        ]);
        $evento->ingressos()->create([
            "lote" => "Lote teste",
            "inicio" => "2023-07-17",
            "fim" => "2023-07-25",
            "quantidade_disponivel" => 250,
            "preco" => 130.89
        ]);
    }

   
}
