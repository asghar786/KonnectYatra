<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Passport;
use Illuminate\Support\Facades\Mail;
class PassportReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Passport Reminder Email';

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
        $passports = Passport::all();
        foreach($passports as $passport)
        {
            $current_date = date("Y-m-d", strtotime("+6 months"));
            if($current_date == $passport->pdoe )
            {
                Mail::raw("Dear $passport->firstname $passport->lastname
We are writing to inform you that your Passport is expiring soon.
We suggest you get your Passport renewed as soon as possible.
Regards
Rashad Mahmood
",function($message) use ($passport)
                {
                    $message->from('konnectus.inc@gmail.com');
                    $message->to($passport->email)->subject('Passport Expire Notification');
                });
            }
            $current_date2 = date("Y-m-d", strtotime("+4 months"));
            if($current_date2 == $passport->expiredate )
            {
                Mail::raw("Dear $passport->firstname $passport->lastname
We are writing to inform you that your NICOP is expiring soon.
We suggest you get your NICOP renewed as soon as possible.
Regards
Rashad Mahmood
$current_date
$passport->expiredate
",function($message) use ($passport)
                {
                    $message->from('konnectus.inc@gmail.com');
                    $message->to($passport->email)->subject('Passport Expire Notification');
                });
            }

            else {
                return;
            }
        }
        $this->info('Reminder Email has been send successfully');
        return 0;
    }
}
