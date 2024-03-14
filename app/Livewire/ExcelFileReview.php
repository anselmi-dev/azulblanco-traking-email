<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExcelFile;
use Livewire\WithPagination;
use App\Jobs\ProcessExcelEmailsByFile;
use WireUi\Traits\Actions;

class ExcelFileReview extends Component
{
    use WithPagination, Actions;

    public ExcelFile $file;

    public function render()
    {
        return view('livewire.excel-file-review', [
            'emails' => $this->file->emails()->with('excel_email')->paginate(50)
        ])->layout('layouts.app');
    }

    public function dispatchFile()
    {
        ProcessExcelEmailsByFile::dispatch($this->file);

        $this->file->touch();

        $this->notification()->success(
            __('El archivo se procesará'),
        );
    }
}
