<?php

namespace App\Observers;

use App\Models\ExcelFile;
use App\Jobs\ProcessExcelFile;
use App\Jobs\ProcessExcelEmailsByFile;

class ExcelFileObserver
{
    /**
     * Handle the ExcelFile "created" event.
     */
    public function created(ExcelFile $excelFile): void
    {
        ProcessExcelFile::dispatchSync($excelFile);

        ProcessExcelEmailsByFile::dispatchSync($excelFile);
    }

    /**
     * Handle the ExcelFile "updated" event.
     */
    public function updated(ExcelFile $excelFile): void
    {
        //
    }

    /**
     * Handle the ExcelFile "deleted" event.
     */
    public function deleted(ExcelFile $excelFile): void
    {
        //
    }

    /**
     * Handle the ExcelFile "restored" event.
     */
    public function restored(ExcelFile $excelFile): void
    {
        //
    }

    /**
     * Handle the ExcelFile "force deleted" event.
     */
    public function forceDeleted(ExcelFile $excelFile): void
    {
        //
    }
}
