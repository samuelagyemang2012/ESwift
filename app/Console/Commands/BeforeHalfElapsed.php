<?php

namespace App\Console\Commands;

use App\Debt;
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
        $d = new Debt();

        $data = $d->two_days_to_half_elapsed();

//        $s->send("233542688902", "cron");


        for ($i = 0; $i < count($data); $i++) {

            $half = $data[$i]->half_debt;
            $total_debt = $data[$i]->total_debt;
            $half_date = $data[$i]->half_loan_date;
            $msisdn = $data[$i]->telephone;

            $msg = "Your half-loan period for your debt of GHC " . $total_debt . " will be due in 2 days. You have to make a payment of GHC " . $half . " by " . $half_date;

            $s->send($msisdn, $msg);
        }

    }
}
