<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;

class SendEmailController extends Controller
{
    public function send($data)
    {
        $email = new SendEmailJob($data);
        dispatch($email);

    }
}
