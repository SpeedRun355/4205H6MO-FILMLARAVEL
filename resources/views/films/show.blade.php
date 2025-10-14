@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <h1>{{ $film->name }} </h1><strong>@lang("general.crée le") : {{ $film->created_at }} </strong>
            <p class="lead">{{ $film->global_rating }}</p>

            <div class="buttons">
                <a href="{{ url('films/'. $film->id .'/edit') }}" class="btn btn-info">@lang("general.modifier")</a>
                <a href="{{ url('/') }}" class="btn btn-info">@lang("general.retour à la page d'acceuil")</a>  
                <form action="{{ url('films/'. $film->id) }}" method="POST" style="display: inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">@lang("general.suprimer")</button>
                </form>
            </div>
        </div>
    </div>

 {{-- Section des commentaires --}}
 <div class="container">   
    <h2> @lang("general.Les commentaires"):</h2>
    @foreach ($film->film_users as $review)
        <strong> @lang("general.nb") {{$review ->id}} @lang("general.by"): {{ $review ->user->name }} - {{ $review->created_at }} </strong>
        <h3>{{ $review->title }}</h2>
     <h3>@lang("general.note") {{ $review->review }}</h3>
     <p class="lead">{{ $review->comment }}</p> 
     <div class="buttons">
     <form action="{{ url('filmUser/'. $review->id) }}" method="POST" style="display: inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">@lang("general.suprimer")</button>
    </form>
</div>
    @endforeach
 {{-- Formulaire d'ajout de commentaires --}}

<h4> @lang("general.Ajouter un commentaire"):</h4>
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
        <label for="author">@lang("general.auteur")</label>
        <input type="text" class="form-control" id="author" placeholder="Entrez votre nom" name="author">
    </div>
        <div class="form-group mb-3">
            <label for="title">@lang("general.titre")</label>
            <input type="text" class="form-control" id="title" placeholder="Entrez votre nom" name="title">
        </div>


        <div class="form-group mb-3">

            <label for="content">@lang("general.Ajouter un commentaire"):</label>
            <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
         
            <input type="hidden" name="film_id" value="{{ $film->id}}" /><br /> 
            {{-- <input type="hidden" value="{{ $film->id}}">{{ $film->id }}/><br /> --}}
          </div>

        <button type="submit" class="btn btn-primary">@lang("general.publier")</button>
    </form>
</div>
@endsection