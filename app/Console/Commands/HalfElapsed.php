<?php

namespace App\Console\Commands;

use App\Debt;
use App\Sms;
use Illuminate\Console\Command;

class HalfElapsed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'halfelapsed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert clients that half loan is due.';

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
        $d = new Debt();

        $data = $d->half_elapsed();

        for ($i = 0; $i < count($data); $i++) {

            $half = $data[$i]->half_debt;
            $total_debt = $data[$i]->total_debt;
            $msisdn = $data[$i]->telephone;

            $msg = "Your half-loan period for your debt of GHC " . $total_debt . " is due today. An amount of GHC " . $half . " is to be paid. You will recieve an sms after deductions have been made from your account";

            $s->send($msisdn, $msg);
        }
    }
}
