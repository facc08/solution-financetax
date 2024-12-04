@extends('layouts.app')

@section('content')
  
<div class="card">
    <div class="card-header">
      <h4>Publicaciones</h4>
    </div>      
    @livewire('post.publicaciones')
    
</div>     


@endsection
