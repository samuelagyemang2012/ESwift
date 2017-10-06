<?php

namespace App\Console\Commands;

use App\Debt;
use App\Sms;
use Illuminate\Console\Command;

class FullElapsed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fullelapsed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert clients that debt is due.';

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

        $data = $d->full_elapsed();

        for ($i = 0; $i < count($data); $i++) {

            $total_debt = $data[$i]->total_debt;
            $msisdn = $data[$i]->telephone;

            $msg = "Your full loan period for your debt of GHC " . $total_debt . " is due today. An amount of GHC " . $total_debt . " is to be paid to settle the debt. Please take note, the interest on this debt will increase every month until the debt is paid.";

            $s->send($msisdn, $msg);
        }
    }
}
