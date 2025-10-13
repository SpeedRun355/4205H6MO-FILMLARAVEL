@extends('layouts.app')


@section('content')

    <h1>Ajouter un film</h1>
    @if ($message = Session::get('warning'))

        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>

    @endif

    <form action="{{ route('film.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="title">Titre:</label>
            <input type="text" class="form-control" id="title" placeholder="Entrez un titre" name="title">
        </div>
        <div class="form-group mb-3">
            <label for="global_rating">Note globale:</label>
            <input type="text" class="form-control" id="global_rating" placeholder="Entrez une note globale" name="global_rating">
        </div>
        <div class="form-group mb-3">
            <label for="film_genre">Genre du film:</label>
            <input type="text" class="form-control" id="film_genre" placeholder="Entrez le genre du film" name="film_genre">
        </div>
        <div class="form-group mb-3">
            <label for="actors">Acteurs:</label>
            <input type="text" class="form-control" id="actors" placeholder="Entrez les acteurs" name="actors">
        </div>
        <div class="form-group mb-3">
            <label for="director">Réalisateur:</label>
            <input type="text" class="form-control" id="director" placeholder="Entrez le réalisateur" name="director">
        </div>

        <input type="hidden" name="user_id" value="<?= 1?>" /><br />
        <button type="submit" class="btn btn-primary">Publier</button>    <a href="{{ url('/') }}" class="btn btn-info">Retour à la page d'accueil</a>  

    </form>

@endsection