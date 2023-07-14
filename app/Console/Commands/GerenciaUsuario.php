<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Permissao;

class GerenciaUsuario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gerencia:usuario {usuarioId : Id do usuario} {--permissao=* : permissoes a serem atribuidas}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerencia usuarios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usarioId = $this->argument("usuarioId");
        $permissao = $this->option("permissao");

        $usuario = User::find($usarioId);

        if(!$usuario) {
            $this->error("Usuario nao encontrado");
            return;
        }
        $permissoes = Permissao::select("id")->whereIn("nome", $permissao)->get();

        if($permissoes->count() > 0){
            $usuario->permissoes()->sync($permissoes);
            $this->info("Permisoes definidas com sucesso");
        }
    }
}
