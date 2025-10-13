
@extends('layouts.app')

    
@section('content')

    <div class="row">

        <div class="col-lg-10">
            <h2>Liste des Films</h2>
        </div>

        <div class="col-lg-2">
            <a class="btn btn-success" href="{{ url('film/create') }}">Ajouter un film</a>
        </div>

    </div>



    @if ($message = Session::get('success'))

        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>

    @endif



<div class="container">

    <div class="row">
        @foreach ($films as $index => $film)
        <div class="col-md-4">
            <div class="card card-body">
         {{--  si vous voulez avoir le titre de votre données cliquable (ici c'est le titre de l'article) utiliser le bout de code ci-bas> --}}
               {{--  <a href="{{ url('films/'. $film->id) }}">
                <h2>
                        {{ $film->name }}
                    </h2>
                   
                </a>  --}}
               
                    <h2>
                            {{ $film->name }}
                        </h2>

                {{ $film->global_rating }}
                          
            <a href="{{ url('film/'. $film->id) }}" class="btn btn-outline-primary">En savoir plus</a> 
            </div>
        </div>
        @endforeach
    </div>
</div>


@endsection 