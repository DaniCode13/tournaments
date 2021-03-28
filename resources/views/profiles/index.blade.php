@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <cards-profile :image="'/images/torneos.png'"
                       :title="'Crear Torneo'"
                       :description="''"
                       :url="'/t/create'">
        </cards-profile>

        <cards-profile :image="'/images/votaciones.png'"
                       :title="'Realizar Encuesta'"
                       :description="''"
                        :url="'/p/create'">

        </cards-profile>
    </div>


    <div class="row">
        <cards-lists :title="'Mis torneos'" :type="'tournaments'"></cards-lists>
        <cards-lists :title="'Mis Encuestas'" :type="'polls'"></cards-lists>

    </div>


</div>
@endsection
