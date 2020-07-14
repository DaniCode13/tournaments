@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <cards-profile :image="'/images/torneos.png'"
                       :title="'Crear Torneo'"
                       :description="'En este apartado puedes crear un torneo y personalizarlo. '"
                       :url="'/t/create'">
        </cards-profile>

        <cards-profile :image="'/images/votaciones.png'"
                       :title="'Realizar Encuesta'"
                       :description="'En este apartado podras crear una encuesta de la forma mas facil y sencillas. '"
                        :url="'/p/create'">

        </cards-profile>
    </div>


    <div class="row">
        <cards-lists :title="'Mis torneos'" :type="'tournaments'"></cards-lists>
        <cards-lists :title="'Mis Encuestas'" :type="'polls'"></cards-lists>

    </div>


</div>
@endsection
