<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Evento;

class EventosIndex extends Component
{
    public $limite = 10;

    public function loadMore()
    {
        $this->limite += 10;
    }

    public function render()
    {
        $eventos = Evento::with('user')
            ->latest()
            ->take($this->limite)
            ->get();

        return view('livewire.admin.eventos-index', compact('eventos'));
    }
}
