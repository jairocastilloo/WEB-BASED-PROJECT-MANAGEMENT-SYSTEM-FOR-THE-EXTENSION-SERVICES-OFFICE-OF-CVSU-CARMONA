@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('Good day,') }} {{ Auth::user()->role }} {{ __(' ') }} {{ Auth::user()->name }} {{ __('!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection