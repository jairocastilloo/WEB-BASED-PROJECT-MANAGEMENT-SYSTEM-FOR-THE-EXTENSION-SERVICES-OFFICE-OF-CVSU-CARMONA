@extends('layouts.app')

@section('content')
<div class="maincontainer shadow">

    <div class="container p-2">
        @livewire('notification-index', [ 'notifications' => $notifications ])
    </div>

</div>


@endsection