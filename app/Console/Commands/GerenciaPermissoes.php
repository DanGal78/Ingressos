<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permissao;

class GerenciaPermissoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gerencia:permissoes {permissaoNome : Nome da Permissao} {--apagar : Apaga a permissao}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria ou apaga uma Permissao no sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permissaoNome = $this->argument("permissaoNome");
        $apagar = $this->option("apagar");

        $permissao = Permissao::where("nome", $permissaoNome)->first();

        if($apagar){
           
            if(!$permissao){
                $this->erro("Permissao apagada com sucesso");
                return;
            }

            $permissao->delete();
            $this->info("Permissao apagada com sucesso");
    }
        if($permissao){
            $this->error("Permissao {$permissao->nome} já existe e nao será criada novamente");
            return;
    }
        Permissao::create(["nome" => $permissaoNome]);
        $this->info("Permissao ${permissaoNome} criada com sucesso");

}
}
