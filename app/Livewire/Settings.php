<?php

namespace App\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Artisan;

class Settings extends Component
{
    use Actions;

    public bool $production = false;

    public int $delay;

    public int $heading_row;

    public string $email_test;

    public function mount ()
    {
        $this->production = settings()->get('production', false);

        $this->delay = settings()->get('delay', 0);

        $this->heading_row = settings()->get('heading_row', 1);

        $this->email_test = settings()->get('email_test', 'carlos@infinety.es');
    }

    public function render()
    {
        return view('livewire.settings')->layout('layouts.app');
    }

    public function submit()
    {
        settings()->set('production', $this->production);

        settings()->set('delay', $this->delay);

        settings()->set('email_test', $this->email_test);

        settings()->set('heading_row', $this->heading_row);

        Artisan::call('queue:restart');

        $this->notification()->success(
            __('Los cambios han sido guardados exitosamente.'),
        );

    }
}
