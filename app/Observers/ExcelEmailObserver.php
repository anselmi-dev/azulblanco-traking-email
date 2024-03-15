<?php

namespace App\Observers;

use App\Models\ExcelEmail;
use App\Jobs\ProcessExcelEmail;

class ExcelEmailObserver
{
    /**
     * Handle the ExcelEmail "created" event.
     */
    public function created(ExcelEmail $excelEmail): void
    {
        ProcessExcelEmail::dispatch($excelEmail);
    }
}
