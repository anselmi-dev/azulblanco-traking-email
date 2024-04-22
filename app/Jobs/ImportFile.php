<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Imports\ImportExcelFile;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ExcelFile;
use Throwable;

class ImportFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ExcelFile $excelFile
    ) {
        // Nothing to do.
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $readerType = $this->getFormatExcel($this->excelFile->file);

        Excel::import(new ImportExcelFile($this->excelFile), $this->excelFile->file, null, $readerType);
    }

    protected function getFormatExcel (string $file)
    {
        if (strpos($file, '.xlsx'))
            return \Maatwebsite\Excel\Excel::XLSX;

        else if (strpos($file, '.xls'))
            return \Maatwebsite\Excel\Excel::XLS;

        return null;
    }

    /**
     * Failed job
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        $this->excelFile->update([
            'status' => 'error'
        ]);

        $this->excelFile->message = $exception->getMessage();
    }
}
