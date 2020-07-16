<?php

namespace App\Console\Commands;

use App\Category;
use App\Item;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateMenuCommand extends Command
{
    protected $signature = 'make:menu';

    public function handle()
    {
        Category::truncate();
        Item::truncate();

        DB::unprepared(file_get_contents(database_path('category_menu.sql')));

        return 0;
    }
}
