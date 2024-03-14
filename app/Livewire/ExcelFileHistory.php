<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExcelFile;
use WireUi\Traits\Actions;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ExcelFileHistory extends Component
{
    use Actions, WithPagination;

    public $paginate = 3;

    public function render()
    {
        return view('livewire.excel-file-history', [
            'files' => ExcelFile::orderByDesc('id')->paginate($this->paginate)
        ]);
    }

    #[On('refresh-excel-file-history')]
    public function refreshExcelFileHistory ()
    {
        $this->resetPage();
    }
}
