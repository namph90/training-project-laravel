<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendEmailJob;

class SendEmailController extends Controller
{
    public function send($data)
    {
        $email = new SendEmailJob($data);
        dispatch($email);

    }
}
