<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use File;

class ImportDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $sql_dump = File::get(dirname(dirname(dirname(dirname(__FILE__)))).'/database.sql');
        DB::connection()->getPdo()->exec($sql_dump);
    }
}
