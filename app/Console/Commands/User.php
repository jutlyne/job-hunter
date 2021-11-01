<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User as UserModel;

class User extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:cron';

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
     * @return int
     */
    public function handle()
    {
        UserModel::query()->update([
            'reset_password_code' => null,
            'email_md5' => null
        ]);
    }
}
