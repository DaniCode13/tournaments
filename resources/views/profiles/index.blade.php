@extends('layouts.app')

@section('content')
<div class="container">
    <cards-profile :imagen="'/images/torneos.png'"
                :titulo="'Crear Torneo'"
                :descripcion="'En este apartado puedes crear un torneo y personalizarlo. '"></cards-profile>
    <cards-profile :imagen="'/images/votaciones.png'"
                :titulo="'Realizar Votación'"
                :descripcion="'En este apartado podras crear una votación de la forma mas facil y sencillas. '">

    </cards-profile>

</div>
@endsection
