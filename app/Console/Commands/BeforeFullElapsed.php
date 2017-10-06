<?php

namespace App\Console\Commands;

use App\Debt;
use App\Sms;
use Illuminate\Console\Command;

class BeforeFullElapsed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beforefullelapsed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert clients 2 days before loan is elapsed.';

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

        $data = $d->two_days_to_full_elapsed();

        for ($i = 0; $i < count($data); $i++) {

            $total_debt = $data[$i]->total_debt;
            $full_date = $data[$i]->full_loan_date;
            $msisdn = $data[$i]->telephone;

            $msg = "Your full loan period for your debt of GHC " . $total_debt . " will be due in 2 days. You have to make full payment of GHC " . $total_debt . " by " . $full_date;

            $s->send($msisdn, $msg);
        }
    }
}
