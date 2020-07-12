<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateMenuCommand extends Command
{
    protected $signature = 'make:menu';

    public function handle()
    {
        DB::unprepared(file_get_contents(database_path('category_menu.sql')));

        return 0;
    }
}
