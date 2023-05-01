@extends('layouts.app')

@section('content')
<div class="row text-white">
    <div class="col-1"></div>
    <div class="col-10">

        <div>{{ __('Monitoring') }}</div>

        <h3>
            @if (session('status'))
            <div>
                {{ session('status') }}
            </div>
            @endif

            {{ __('Good day,') }} {{ Auth::user()->role }} {{ __(' ') }} {{ Auth::user()->name }}{{ __('!') }}
        </h3>
        <p>{{ date('l, F jS, Y') }}.</p>

        <div class="table-responsive m-4">
            <table class="table table-bordered table-dark table-hover">
                <thead>
                    <tr>
                        <th class="col-6">Column 1</th>
                        <th class="col-3">Column 2</th>
                        <th class="col-2">Column 3</th>
                        <th class="col-1">Column 4</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Data 1</td>
                        <td>Data 2</td>
                        <td>Data 3</td>
                        <td>Data 4</td>
                    </tr>
                    <tr>
                        <td>Data 5</td>
                        <td>Data 6</td>
                        <td>Data 7</td>
                        <td>Data 8</td>
                    </tr>
                    <tr>
                        <td>Data 9</td>
                        <td>Data 10</td>
                        <td>Data 11</td>
                        <td>Data 12</td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>
    <div class="col-1"></div>
</div>
@endsection