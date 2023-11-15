@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-top-0 pb-5">

    <div class="container pt-2 px-4">
        @livewire('configuration-settings', [ 'user' => $user ])
    </div>
</div>

@endsection