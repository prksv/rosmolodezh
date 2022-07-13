<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UserComponent extends Component
{
    public $user;

    public function render()
    {
        return view('livewire.user-component');
    }
}
