<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tests\TestCase;

class AutenticacaoTest extends TestCase
{
    use RefreshDatabase;

    public const BASE_URL = "/api/credenciais";
    /**
     * A basic feature test example.
     */
    public function teste_cadastro_usuarios(){
        $respose = $this->post(self::BASE_URL . "/registrar", [
            "name" => "Daniel Galdino",
            "email" => "email@email.com",
            "password" => "12345678",
            "password_confirmation" => "12345678"
        ], [
            "Accept" => "application/json"
        ]);
        $respose->assertCreated();
        $respose->assertJsonPath("message","Usuário cadastrado com sucesso");
    }

    public function teste_login_usuario(){
        $this->cadastraUsuario();

        $respose = $this->post(self::BASE_URL ."/login", [
            "email" => "email@email.com",
            "password" => "12345678",
        ], [
            "Accept" => "application/json"
        ]);

        $respose->assertOk();
        $respose->assertJsonPath("tipo", "Bearer");                  
                       
    }

    public function teste_exibe_usuario_autenticado(){
        $this->cadastraUsuario();
        $token = auth()->attempt([
            "email" => "email@email.com",
            "password" => "12345678",
        ]);
        $respose = $this->get(self::BASE_URL . "/me",[
            "Accept" => "application/json",
            "Authorization" => "Bearer". $token

        ]);
        $respose->assertOk();
        $respose->assertJsonPath("email", "email@email.com");       
    }
    public function test_atualiza_token(){

        $this->cadastraUsuario();
        $token = auth()->attempt([
            "email" => "email@email.com",
            "password" => "12345678",
        ]);
        $respose = $this->put(self::BASE_URL . "/refresh",[
            "Accept" => "application/json",
            "Authorization" => "Bearer". $token

        ]);
        $respose->assertOk();
        $this->assertTrue($token != $respose->json("token"),"O token nao pode ser igual ao envido");  
    }

    private function cadastraUsuario(){
        $user = User::where("email", "email@email.com")->first();

        if ($user){
            return $user;
        }


        return User::create([
            "name" => "Daniel Galdino",
            "email" => "email@email.com",
            "password" => Hash::make("12345678"),
        ]);
    }
}
