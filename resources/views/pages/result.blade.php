@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="">
            <p>Результат</p>

            <div class="">
                {{ var_dump($data) }}
            </div>
        </div>
    </div>

@endsection