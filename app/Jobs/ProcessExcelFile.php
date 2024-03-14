<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ExcelFile;
use App\Imports\ImportExcelFile;
use Excel;

class ProcessExcelFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ExcelFile $excelFile;

    /**
     * Create a new job instance.
     */
    public function __construct(ExcelFile $excelFile)
    {
        $this->excelFile = $excelFile;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Excel::import(new ImportExcelFile($this->excelFile), public_path($this->excelFile->file_path));
    }
}
