<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExcelFile;

class StatusExcelFile extends Component
{
    public ExcelFile $file;

    public $status;

    public function mount(ExcelFile $file)
    {
        $this->file = $file;

        $this->status = $file->status;
    }

    public function render()
    {
        return view('livewire.status-excel-file');
    }

    public function refresh()
    {
        try {
            $this->file->refresh();
        } catch (\Throwable $th) {
            return abort(404);
        };

        $this->status = $this->file->status;

        if ($this->file->is_processed) {
            $this->dispatch('status-excel-done');
        }
    }
}
