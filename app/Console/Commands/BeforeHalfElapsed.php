<?php

namespace App\Console\Commands;

use App\Sms;
use Illuminate\Console\Command;

class BeforeHalfElapsed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beforehalfelapsed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert clients 2 days before half loan is expired.';

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
        $s = new Sms();
        $s->send("233542688902", "cron test");
    }
}
