<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Http\Requests\RegistraUsuarioRequest;
use App\Models\User;

class AutenticacaoController extends Controller
{
    public function registrar(RegistraUsuarioRequest $request) 
    {
        $usuarioRequestData = $request->all();
        $usuarioRequestData["password"] = Hash::make($usuarioRequestData["password"]);

        $usuario = User::create($request->all());

        return response()->json(["massage" =>"Usuário cadastrado com sucesso"], Response::HTTP_CREATED);
    }
}
