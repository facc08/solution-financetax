<?php

namespace App\Http\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class FotoPerfile extends Component
{
    use WithFileUploads;
    public $user , $image;

    public function render()
    {
        $this->user      = Auth::user();
        return view('livewire.admin.user.foto-perfile');
    }

    protected $rules = [
        'image' => 'required|mimes:jpg,jpeg,bmp,png',

    ];

    public function StoreImage(){

        $this->validate();

        $image =  $this->image->store("/foto-perfil" , 'public_upload');
        $user  = Auth::user();
        $user->image      = $image;
        $user->save();

        $this->emit('info',['mensaje' => 'Foto Actualizados Correctamente']);
    }
}
