@extends('layouts.app')


@section('content')


    <h1>Modifier Film: {{ $film->titre }}</h1>


    <h1>Ajouter un film</h1>
    @if ($message = Session::get('warning'))

        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>

    @endif

    <form method="post" action="{{ url('films/'. $film->id) }}" >
        @method('PATCH')
        @csrf


        <div class="form-group mb-3">

            <label for="title">Titre:</label>
            <input type="text" class="form-control" id="title" placeholder="Entrer titre" name="title" value="{{ $film->name }}">

        </div>

        <div class="form-group mb-3">

            <label for="content">Ajouter le contenu:</label>
            <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ $film->global_rating}}</textarea>

        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
       
            <a href="{{ url('films/'. $film->id) }}" class="btn btn-info">Annuler</a>  
    </form>
   
  
@endsection