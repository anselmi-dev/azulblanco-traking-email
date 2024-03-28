<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ExcelFile;
use App\Mail\PrivateShipped;

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
        $this->excelFile->update([
            'status' => 'sending'
        ]);

        $excel_emails = $this->excelFile->excel_emails()->doesntHave('own_email')->get();

        foreach ($excel_emails as $key => $excel_email) {
            try {

                if ($excel_email->own_email)
                    return;

                $email = app()->environment('production') && settings()->get('production', false) ? $excel_email->email : settings()->get('email_test', 'carlos@infinety.es');

                \Mail::to($email)->later(now()->addSeconds((int) settings()->get('delay', 0)), new PrivateShipped($excel_email));

                $excel_email->status = 'sending';

                $excel_email->save();

            } catch (\Throwable $th) {

                report($th);

                $excel_email->status = 'error';

                $excel_email->save();

                $this->erros++;

                $this->excelFile->update([
                    'status' => 'error'
                ]);
            }
        }

        if (!$excel_emails->count())
            $this->excelFile->update([
                'status' => 'done'
            ]);
    }
}
