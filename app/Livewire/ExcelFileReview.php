<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExcelFile;
use Livewire\WithPagination;
use App\Jobs\ProcessExcelEmailsByFile;
use WireUi\Traits\Actions;
use Livewire\Attributes\On;

class ExcelFileReview extends Component
{
    use WithPagination, Actions;

    public ExcelFile $file_excel;

    public $filters = [
        'search' => '',
        'status' => '',
        'role' => ''
    ];

    public $no_emails_sent = false;

    public function render()
    {
        $this->no_emails_sent = $this->file_excel->is_error && $this->file_excel->excel_emails()->doesntHave('own_email')->exists();

        return view('livewire.excel-file-review', [
            'excel_emails' => $this->file_excel->excel_emails()
                ->when($this->filters['search'], function ($query) {
                    $query->where('obra', 'LIKE', "%".$this->filters['search']. '%')
                        ->orWhere('email', 'LIKE', "%".$this->filters['search']. '%');
                })->when($this->filters['status'], function ($query) {
                    $query->where('status', $this->filters['status']);
                })->when($this->filters['role'], function ($query) {
                    $query->where('role', $this->filters['role']);
                })->with('own_email')->paginate(50)
        ])->layout('layouts.app');
    }

    public function updatingFilters()
    {
        $this->resetPage();
    }

    #[On('status-excel-done')]
    public function refreshComponent()
    {
        $this->resetPage();
    }

    public function delete()
    {
        $this->file_excel->delete();

        return redirect()->route('dashboard');
    }

    public function dispatchFile()
    {
        ProcessExcelEmailsByFile::dispatch($this->file_excel);

        $this->no_emails_sent = false;

        $this->notification()->success(
            __('Los correos que aún no han sido procesados se añadirán a la cola de envío.'),
        );
    }
}
