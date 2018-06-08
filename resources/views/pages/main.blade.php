@extends('layouts.default')

@section('content')
    <div class="container">
        <form action="{{ route('check') }}" method="post">
            {{ csrf_field() }}
            <div class="form-row align-items-center">
                <div class="col-sm-6 my-1">
                    <label class="sr-only" for="site">Сайт</label>
                    <input type="text" name="site" class="form-control" id="site" placeholder="Введите сайт">
                </div>
                <div class="col-sm-3 my-1">
                    <button type="submit" class="btn btn-primary">Проверка</button>
                </div>
            </div>
        </form>
    </div>

@endsection