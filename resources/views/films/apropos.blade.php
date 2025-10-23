@extends('layouts.app')

@section('content')

<h1>À propos de nous</h1>
<div>
    <p>Ce site a été créé par Félix-Etienne Hamel et Mario Alejandro Diaz Alvarez</p>
    <p>420-5H6 MO Applications Web transactionnelles.</p>
    <p>Automne 2025, Collège Montmorency</p>
    <p>Pour tester tester les fonctionnalitées du site, ajoutez un site avec le bouton en remplissant tout les champs</p>
    <p>Ensuite, vous pouvez voir les détails du film en cliquant sur "En savoir plus"</p>
    <p>Vous pouvez aussi modifier ou suprimer le film en question</p>
    <p>Vous pouvez aussi changer la langue du site en utilisant le menu déroulant en haut à droite</p>
    <img src="{{ asset('images/upload/image.png') }}" alt="bd" style="max-width:100%; height:auto;">
</div>
@endsection