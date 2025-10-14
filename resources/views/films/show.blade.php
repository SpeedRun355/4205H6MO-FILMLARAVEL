@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            @if ($film->photo)
              <img src="../images/upload/{{$film->photo}}"width="200px" height="100px">
            @endif
            <h1>{{ $film->name }} </h1><strong>Crée le: {{ $film->created_at }} </strong>
            <p class="lead">{{ $film->global_rating }}</p>

            <div class="buttons">
                <a href="{{ url('film/'. $film->id .'/edit') }}" class="btn btn-info">Modifier</a>
                <a href="{{ url('/') }}" class="btn btn-info">Retour à la page d'accueil</a>  
                <form action="{{ url('film/'. $film->id) }}" method="POST" style="display: inline">
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
            <label for="review">Note:</label>
            <input type="text" class="form-control" id="review" placeholder="Entrez votre note" name="review">
        </div>

        <div class="form-group mb-3">
            <label for="comment">Ajouter votre commentaire:</label>
            <textarea name="comment" id="comment" cols="30" rows="10" class="form-control"></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="user_id">User ID :</label>
            <input type="text" class="form-control" id="user_id" placeholder="Entrez votre user id" name="user_id">
        </div>

        <input type="hidden" name="film_id" value="{{ $film->id}}" /><br />

        <button type="submit" class="btn btn-primary">Publier</button>
    </form>
</div>
@endsection