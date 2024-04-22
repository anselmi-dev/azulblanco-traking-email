<?php

namespace App\Observers;

use App\Models\ExcelFile;
use App\Jobs\ProcessExcelEmailsByFile;
use App\Jobs\ImportFile;

class ExcelFileObserver
{
    /**
     * Handle the ExcelFile "created" event.
     */
    public function created(ExcelFile $excelFile): void
    {
        ImportFile::dispatch($excelFile);
    }

    /**
     * Handle the ExcelFile "created" event.
     */
    public function updated(ExcelFile $excelFile): void
    {
        if ($excelFile->is_sending) {
            ProcessExcelEmailsByFile::dispatch($excelFile);
        }
    }

}
