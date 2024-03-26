<?php

namespace App\Livewire;

use App\Models\ExcelEmail;
use Livewire\Component;
use App\Models\OwnEmailSentModel;
use Livewire\WithPagination;

class ReviewEmails extends Component
{
    use WithPagination;

    public $filters = [
        'search' => '',
        'status' => '',
        'role' => ''
    ];

    public function render()
    {
        return view('livewire.review-emails', [
            'excel_emails' => ExcelEmail::with('own_email')->orderByDesc('id')->when($this->filters['search'], function ($query) {
                $query->where('obra', 'LIKE', "%".$this->filters['search']. '%')
                    ->orWhere('email', 'LIKE', "%".$this->filters['search']. '%');
            })->when($this->filters['status'], function ($query) {
                $query->where('status', $this->filters['status']);
            })->when($this->filters['role'], function ($query) {
                $query->where('role', $this->filters['role']);
            })->paginate(50)
        ])->layout('layouts.app');
    }

    public function updatingFilters()
    {
        $this->resetPage();
    }
}
