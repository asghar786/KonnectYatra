<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use Illuminate\Support\Facades\Mail;

class ReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Reminder Email of Expiration';

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
        $students = Student::all();
        foreach($students as $student)
        {
            $current_date = date("Y-m-d", strtotime("+1 months"));
            if($current_date == $student->coursecompletiondate )
            {
                Mail::raw("Dear $student->firstname $student->lastname
We are writing to inform you that your Defense Driving Course is expiring soon.
We suggest you get your DDC renewed as soon as possible and get a 10% discount on your Vehicle Insurance and have the advantage of the deletion of 4 points on your driving record if applicable to you.
Regards
Rashad Mahmood
",function($message) use ($student)
                {
                    $message->from('konnectus.inc@gmail.com');
                    $message->to($student->email)->subject('DDC Reminder Notification');
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
