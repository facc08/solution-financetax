<?php

namespace App\Http\Livewire\Admin\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Contrasena extends Component
{
    public $password, $password_confirmation;

    public function render()
    {
        return view('livewire.admin.user.contrasena');
    }


    public function ChangePassword (){
        $this->validate([
            'password' => 'required|min:8|max:15|confirmed',
            'password_confirmation' => 'required',
        ],[
            'password.required'              => 'La contraseña es requerida',
			'password_confirmation.required' => 'La contraseña es requerida',
			'password.confirmed'             => 'Las contraseñas no coinciden',
        ]);
       $u = Auth::user();
       $u->password = Hash::make($this->password);
       $u->save();
       $this->ResetInput();
       $this->emit('info',['mensaje' => 'Contrasena Actualizada Correctamente']);
    }



    public function ResetInput(){
        $this->password = null;
        $this->password_confirmation = null;
    }
}
