<?php

namespace App\Http\Controllers;
use App\Mail\ExpiryReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Student;
class ReminderEmailController extends Controller
{
    public function mail()
    {
        $data = "Checking Cronjob From Laravel";
        $student_email = Student::all()->pluck('email');
        Mail::to($student_email)->send(new ExpiryReminder($data));
        return 'Email Sent Successfuly';
    }
}
