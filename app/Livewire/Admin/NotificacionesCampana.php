<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Evento;

class NotificacionesCampana extends Component
{
    public $sinVer = 0;

    public function mount()
    {
        $this->actualizarConteo();
    }

    public function actualizarConteo()
    {
        $this->sinVer = Evento::where('visto', false)->count();
    }

    public function render()
    {
        return view('livewire.admin.notificaciones-campana');
    }
}
