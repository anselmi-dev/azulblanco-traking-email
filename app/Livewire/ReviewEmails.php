<?php

namespace App\Livewire;

use App\Models\ExcelEmail;
use Livewire\Component;
use App\Models\OwnEmailSentModel;
use Livewire\WithPagination;

class ReviewEmails extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.review-emails', [
            'excel_emails' => ExcelEmail::with('own_email')->orderByDesc('id')->paginate(20)
        ])->layout('layouts.app');
    }
}
