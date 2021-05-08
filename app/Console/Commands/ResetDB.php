<?php namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ResetDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resetdb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina todas las tablas de la base de datos';

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

        if (!$this->confirm('¿QUIERES REINICIAR LA BASE DE DATOS? [y|N]')) {
            exit('Se abortó el borrado de las tablas');
        }

        $this->comment(PHP_EOL."Borrando tablas...".PHP_EOL);

        $colname = 'Tables_in_' . env('DB_DATABASE');

        $tables = DB::select('SHOW TABLES');

        foreach($tables as $table) {
            $droplist[] = $table->$colname;
        }

        if(isset($droplist)){
            $droplist = implode(',', $droplist);

            DB::beginTransaction();
            //turn off referential integrity
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            DB::statement("DROP TABLE $droplist");
            //turn referential integrity back on
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            DB::commit();
        }

        $this->comment(PHP_EOL."¡Tablas borradas!".PHP_EOL);

        $this->comment(PHP_EOL."Migrando tablas...".PHP_EOL);

        Artisan::call('migrate');

        $this->comment(PHP_EOL."¡Tablas migradas!".PHP_EOL);

        if (!$this->confirm('¿QUIERES EJECUTAR LOS SEEDER? [y|N]')) {
            $this->comment(PHP_EOL."Seeder no ejecutado".PHP_EOL);
        }else{
            $this->comment(PHP_EOL."Limpiando cache del autoloader...".PHP_EOL);
            shell_exec('composer dumpautoload');
            $this->comment(PHP_EOL."¡Autoloader generado!".PHP_EOL);
            Artisan::call('db:seed');
            $this->comment(PHP_EOL."Inventando datos...".PHP_EOL);

            $this->comment(PHP_EOL."¡Seeders ejecutados!".PHP_EOL);

        }

        $this->comment(PHP_EOL."Fin. Si no se han mostrado errores, se reinició correctamente".PHP_EOL);

    }
}
