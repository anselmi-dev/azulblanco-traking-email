<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExcelFile;

class ExcelFileCard extends Component
{
    public ExcelFile $file;

    public function mount(ExcelFile $file)
    {
        $this->file = $file;
    }

    public function render()
    {
        return view('livewire.excel-file-card');
    }
}
