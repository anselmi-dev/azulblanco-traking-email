<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExcelFile;
use Livewire\WithPagination;

class ExcelFileReview extends Component
{
    use WithPagination;

    public ExcelFile $file;

    public function render()
    {
        return view('livewire.excel-file-review', [
            'emails' => $this->file->emails()->paginate(50)
        ])->layout('layouts.app');
    }
}
