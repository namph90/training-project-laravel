<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employee;

    /**
     * Create a new job instance.
     *
     * @param $employee
     */
    public function __construct($employee)
    {
        $this->queue = 'email';
        $this->employee = $employee;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new SendEmail($this->employee);
        Mail::to($this->employee->email)->queue($email);
        Log::info('New Job', ['id' => $this->employee->id, 'email' => $this->employee->email]);

    }

    public function failed()
    {
        Log::info('Fail Job', ['id' => $this->employee->id, 'email' => $this->employee->email]);
    }
}
