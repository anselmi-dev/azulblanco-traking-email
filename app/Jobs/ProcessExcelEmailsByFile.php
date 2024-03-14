<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ExcelFile;

class ProcessExcelEmailsByFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $erros = 0;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ExcelFile $excelFile
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $excel_emails = $this->excelFile->excel_emails;

        foreach ($excel_emails as $key => $excel_email) {
            try {
                // $excel_email->email_arqui
                \Mail::to('carlosanselmi2@gmail.com')->send(new \App\Mail\PrivateShipped($excel_email));

                $excel_email->status = 'done';

                $excel_email->save();

            } catch (\Throwable $th) {
                report($th);

                $excel_email->status = 'error';

                $excel_email->save();

                $this->erros++;
            }
        }

        $this->excelFile->update([
            'status' => $this->erros ? 'error' : 'done'
        ]);
    }
}
