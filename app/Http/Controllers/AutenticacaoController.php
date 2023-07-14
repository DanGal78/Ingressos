<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Http\Requests\RegistraUsuarioRequest;
use App\Models\User;
use App\Http\Requests\LoginRequest;

class AutenticacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api", ["except" => ["login", "registar"]]);
    }


    public function registrar(RegistraUsuarioRequest $request) 
    {
        $usuarioRequestData = $request->all();
        $usuarioRequestData["password"] = Hash::make($usuarioRequestData["password"]);

        $usuario = User::create($request->all());

        return response()->json(["massage" =>"Usuário cadastrado com sucesso"], Response::HTTP_CREATED);
    }
    public function login(LoginRequest $request){
        $token = auth()->attempt($request->only(["email", "password"]));
        if(!$token){
            return response()->json(["massage" => "Usuário ou senha invalido"], Response::HTTP_UNAUTHORIZED);

    }
    return $this->respostaToken($token);
}

public function refresh(){
    return $this->respostaToken(auth()->refresh());
}
public function me(){
    return response()->json(auth()->user(), Response::HTTP_OK);
}
protected function respostaToken(string $token)
{
    return response()->json([
        "token" => $token,
        "tipo" => "Bearer"
    ], Response::HTTP_OK);
}
}