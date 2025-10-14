@extends('layouts.app')


@section('content')


    <h1>Modifier Film: {{ $film->titre }}</h1>


    <h1>Ajouter un film</h1>
    @if ($message = Session::get('warning'))

        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>

    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="post" action="{{ url('film/'. $film->id) }}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="form-group mb-3">
            <label for="name">Titre:</label>
            <input type="text" class="form-control" id="name" placeholder="Entrez un titre" name="name" value="{{ $film->name }}">
        </div>
        <div class="form-group mb-3">
            <label for="global_rating">Note globale:</label>
            <input type="text" class="form-control" id="global_rating" placeholder="Entrez une note globale" name="global_rating" value="{{ $film->global_rating }}">
        </div>
        <div class="form-group mb-3">
            <label for="film_genre">Genre du film:</label>
            <input type="text" class="form-control" id="film_genre" placeholder="Entrez le genre du film" name="film_genre" value="{{ $film->film_genre }}">
        </div>
        <div class="form-group mb-3">
            <label for="actors">Acteurs:</label>
            <input type="text" class="form-control" id="actors" placeholder="Entrez les acteurs" name="actors" value="{{ $film->actors }}">
        </div>
        <div class="form-group mb-3">
            <label for="director">Réalisateur:</label>
            <input type="text" class="form-control" id="director" placeholder="Entrez le réalisateur" name="director" value="{{ $film->director }}">
        </div>
        <div class="form-group mb-3">
            <label><strong>Modifier l'Image</strong></label>
            <input type = "file" name= "photo"  class = "form-control">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
       
        <a href="{{ url('films/'. $film->id) }}" class="btn btn-info">Annuler</a>  
    </form>
   
  
@endsection