@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <h1>{{ $film->name }} </h1><strong>Crée le: {{ $film->created_at }} </strong>
            <p class="lead">{{ $film->global_rating }}</p>

            <div class="buttons">
                <a href="{{ url('films/'. $film->id .'/edit') }}" class="btn btn-info">Modifier</a>
                <a href="{{ url('/') }}" class="btn btn-info">Retour à la page d'accueil</a>  
                <form action="{{ url('films/'. $film->id) }}" method="POST" style="display: inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>

 {{-- Section des commentaires --}}
 <div class="container">   
    <h2> Les commentaires:</h2>
    @foreach ($film->film_users as $review)
        <strong> Commentaire numéro {{$review ->id}} rédigé par: {{ $review ->user->name }} le {{ $review->created_at }} </strong>
        <h3>{{ $review->title }}</h2>
     <h3>Note: {{ $review->review }}</h3>
     <p class="lead">{{ $review->comment }}</p> 
     <div class="buttons">
     <form action="{{ url('filmUser/'. $review->id) }}" method="POST" style="display: inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Supprimer</button>
    </form>
</div>
    @endforeach
 {{-- Formulaire d'ajout de commentaires --}}

<h4> Ajouter un commentaire:</h4>
<div class="form-group mb-4">

    @if ($message = Session::get('warning'))

        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>

    @endif
    
  {{-- <form action="{{ url(url('films/'. $film->id). '/comments') }}" method="POST" enctype="multipart/form-data">  --}}
    <form action="{{route('filmUser.store')}}" method="POST" enctype="multipart/form-data"> 

        @csrf
        <div class="form-group mb-3">
        <label for="author">Auteur</label>
        <input type="text" class="form-control" id="author" placeholder="Entrez votre nom" name="author">
    </div>
        <div class="form-group mb-3">
            <label for="title">Titre</label>
            <input type="text" class="form-control" id="title" placeholder="Entrez votre nom" name="title">
        </div>


        <div class="form-group mb-3">

            <label for="content">Ajouter votre commentaire:</label>
            <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
         
            <input type="hidden" name="film_id" value="{{ $film->id}}" /><br /> 
            {{-- <input type="hidden" value="{{ $film->id}}">{{ $film->id }}/><br /> --}}
          </div>

        <button type="submit" class="btn btn-primary">Publier</button>
    </form>
</div>
@endsection