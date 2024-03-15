<?php

namespace App\Jobs;

use App\Models\ExcelEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessExcelEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ExcelEmail $excel_email
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            if ($this->excel_email->own_email)
                return;

            \Mail::to('carlosanselmi2@gmail.com')->send(new \App\Mail\PrivateShipped($this->excel_email));

            $this->excel_email->status = 'done';

            $this->excel_email->save();

        } catch (\Throwable $th) {

            report($th);

            $this->excel_email->status = 'error';

            $this->excel_email->save();
        }
    }
}
