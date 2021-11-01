<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Lang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:publish {lang}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish lang';

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
     * @return int
     */
    public function handle()
    {
        $lang = $this->argument('lang');
        $src = 'vendor/laravel-lang/lang/src/' . $lang;
        $dst = 'resources/lang/' . $lang;
        File::copyDirectory($src, $dst);
        return 0;
    }
}
