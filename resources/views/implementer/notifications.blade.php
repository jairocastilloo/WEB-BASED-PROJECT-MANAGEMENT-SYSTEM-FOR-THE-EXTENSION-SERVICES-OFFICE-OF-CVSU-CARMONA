@extends('layouts.app')

@section('content')
<div class="maincontainer shadow px-4 pt-4">

    @livewire('notification-index', [ 'notifications' => $notifications ])

</div>


@endsection