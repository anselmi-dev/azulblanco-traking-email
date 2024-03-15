<?php

namespace App\Observers;

use App\Models\ExcelFile;
use App\Jobs\ProcessExcelFile;

class ExcelFileObserver
{
    /**
     * Handle the ExcelFile "created" event.
     */
    public function created(ExcelFile $excelFile): void
    {
        ProcessExcelFile::dispatch($excelFile);
    }
}
