<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Limpiar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'limpiar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para limpiar las caches de laravel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Limpiado archivos temporales y cache');
        Artisan::call('optimize:clear');
//        Artisan::call('cache:clear');
//        $this->line('Cache ok');
//        Artisan::call('view:clear');
//        $this->line('View ok');
//        Artisan::call('config:clear');
//        $this->line('Config ok');
        $this->line('OK');
    }
}
