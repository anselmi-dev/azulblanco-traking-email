<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OwnEmailSentModel;
use Livewire\WithPagination;

class ReviewEmails extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.review-emails', [
            'emails' => OwnEmailSentModel::orderByDesc('id')->paginate(20)
        ])->layout('layouts.app');
    }
}
