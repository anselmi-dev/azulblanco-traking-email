<?php

namespace App\Livewire;

use App\Models\ExcelFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use WireUi\Traits\Actions;
use App\Imports\ImportExcelFile;

class ImportExcel extends Component
{
    use WithFileUploads, Actions;

    #[Validate([
        'files' => 'required',
        'files.*' => [
            'required',
            'max:104203'
        ],
    ])]
    public array $files = [];

    public bool $production = false;

    public function __construct()
    {
        $this->production = settings()->get('production', false);
    }

    public function render()
    {
        return view('livewire.import-excel')->layout('layouts.app');
    }

    public function submit()
    {
        $this->validate();

        foreach ($this->files as $key => $file) {

            $_FILE = new File($file['path']);

            $_FILENAME = date('Y-m-d') . '/' . $_FILE->hashName();

            $file_path = Storage::putFileAs(ExcelFile::DISK, $_FILE, $_FILENAME);

            auth()->user()->execel_files()->create([
                'file' => $file_path,
                'original_name' => optional($file)['name'],
            ]);
        }

        $this->notification()->success(
            __('El archivo se subió correctamente'),
        );

        $this->dispatch('refresh-excel-file-history');

        $this->reset();
    }
}
