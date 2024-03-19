<?php

namespace App\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;

class Settings extends Component
{
    use Actions;

    public bool $production = false;

    public function mount ()
    {
        $this->production = settings()->get('production', false);
    }

    public function render()
    {
        return view('livewire.settings')->layout('layouts.app');
    }

    public function submit()
    {
        settings()->set('production', $this->production);
    }
}
