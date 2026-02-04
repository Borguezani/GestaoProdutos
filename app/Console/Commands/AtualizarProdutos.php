<?php

namespace App\Console\Commands;

use App\Models\Produto;
use Illuminate\Console\Command;

class AtualizarProdutos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atualizar-produtos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza o status dos produtos baseado na quantidade em estoque';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando atualização de status dos produtos...');

        $inativados = Produto::where('quantidade', '<=', 0)
            ->where('ativo', true)
            ->update(['ativo' => false]);

        $ativados = Produto::where('quantidade', '>', 0)
            ->where('ativo', false)
            ->update(['ativo' => true]);

        $this->info("Produtos inativados: {$inativados}");
        $this->info("Produtos ativados: {$ativados}");
        $this->info('Atualização concluída com sucesso!');

        return true;
    }
}
