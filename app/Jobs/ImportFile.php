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

class ImportFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        Excel::import(new ImportExcelFile($this->excelFile), $this->excelFile->file, null, $this->getFormatExcel($this->excelFile->file));
    }

    protected function getFormatExcel (string $file)
    {
        if (strpos($file, '.xlsx'))
            return \Maatwebsite\Excel\Excel::XLSX;

        else if (strpos($file, '.xls'))
            return \Maatwebsite\Excel\Excel::XLS;

        return null;
    }
}
