<?php

namespace App\Observers;

use App\Models\ExcelFile;
use App\Imports\ImportExcelFile;
use App\Jobs\ProcessExcelEmailsByFile;
use Maatwebsite\Excel\Facades\Excel;

class ExcelFileObserver
{
    /**
     * Handle the ExcelFile "created" event.
     */
    public function created(ExcelFile $excelFile): void
    {
        Excel::queueImport(new ImportExcelFile($excelFile), $excelFile->file);
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
