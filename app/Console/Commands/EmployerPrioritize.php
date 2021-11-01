<?php

namespace App\Console\Commands;

use App\Repositories\Employer\EmployerRepository;
use Illuminate\Console\Command;

class EmployerPrioritize extends Command
{
    protected $employerRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employer:cron';

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
    public function __construct(EmployerRepository $employerRepository)
    {
        parent::__construct();
        $this->employerRepository = $employerRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->employerRepository->handleScheduleEmployerDate();
    }
}
