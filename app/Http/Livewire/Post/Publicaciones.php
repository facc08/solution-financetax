<?php

namespace App\Http\Livewire\Post;

use App\Events\PostEvent;
use App\Post;
use App\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Publicaciones extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap'; //para admitir los links de bootstrap 
    protected $listeners       = ['eliminarPost']; //para eliminar registros 
    protected $queryString     =['search' => ['except' => ''],
    'page', ];  //para busqueda de datos 

 


    
    public $perPage   = 10;
    public $search    = '';
    public $orderBy   = 'id';
    public $orderAsc  = true;
    public $post_id   = '';
    public $estado    ='activo';
    
    public $editMode   = false;
    public $createMode = false;
    public $filter     = '';

    public $titulo, $resumen, $user_id='';

   public function mount(){
    $this->estado    ='activo';
    
    
   }


    public function render()
    {
        $this->users= User::all();
        // $data = Post::where(function($query){
        //     $query->where('posts.titulo', 'like','%'. $this->search . '%');
        // })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        //   ->paginate($this->perPage); para obtener datos de una misma tabla

        $data = Post::join('users', 'users.id' ,'=', 'posts.user_id')
                ->where(function($query){
                $query->where('posts.titulo', 'like', '%' .$this->search.'%');
                })
                ->where(fn($query) =>$this->filter ? $query->where('users.name', $this->filter) : '')
                ->select('posts.*', 'users.name as user') 
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);

        // $data = Post::join('users', 'users.id' ,'=', 'posts.user_id')
        //                     ->where('user_id', Auth::user()->id)
        // ->where(function($query){
        // $query->where('posts.titulo', 'like', '%' .$this->search.'%');
        // })
        // ->where(fn($query) =>$this->filter ? $query->where('users.name', $this->filter) : '')
        // ->select('posts.*', 'users.name as user') 
        // ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        // ->paginate($this->perPage);

        return view('livewire.post.publicaciones', compact('data'));
    }


    public function resetInput(){
        $this->titulo = null;
        $this->resumen = null;
        $this->estado = 'activo';
        $this->editMode = false;
       // $this->resetValidation();

    }


    public function createPost(){
        $this->validate([
            'resumen' => 'required',
            'titulo' => 'required',
        ],[
            'titulo.required'      => 'No has agregado el titulo ',
            'resumen.required'     => 'No has agregado el resumen ',
        ]);

        $this->createMode = true;

        $p = new Post;
        $p->titulo   = $this->titulo;
        $p->user_id  = Auth::id();
        $p->resumen  = $this->resumen;
        $p->estado    = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $p->save();
       
        $this->resetInput();
        $this->emit('success',['mensaje'=> 'Publicación Creada con Exito', 'modal' => '#createPost'] );
        event(new PostEvent($p));
        $this->createMode = false;
      
      
    }


    public function editPost($id){

        $p = Post::find($id);
        $this->post_id   = $id;
        $this->titulo    = $p->titulo;
        $this->resumen   = $p->resumen;
        $this->estado    = $p->estado;
        $this->editMode  = true;
    }

    public function updatePost(){


        $this->validate([
            'resumen' => 'required',
            'titulo' => 'required',
        ],[
            'titulo.required'      => 'No has agregado el titulo ',
            'resumen.required'     => 'No has agregado el resumen ',
        ]);

        

        $p =  Post::find($this->post_id);
        $p->titulo = $this->titulo;
        $p->resumen = $this->resumen;
        $p->estado = $this->estado;
        $p->save();
        $this->resetInput();
        $this->emit('success',['mensaje'=> 'Publicación Actualizada con Exito', 'modal' => '#createPost'] );

    }



    public function eliminarPost($id)
    {
        $c = Post::find($id);
        $c->delete();
        $this->emit('info', ['mensaje' => 'Publicación Eliminado Correctamente']);
    }


    public function estadochange($id)
    {

        $estado = Post::find($id);
        $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
        $estado->save();
        $this->emit('info', ['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);
    }





}
