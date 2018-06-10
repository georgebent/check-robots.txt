@extends('layouts.default')

@section('content')
    <div class="container">
        <form action="{{ route('check') }}" method="post">
            {{ csrf_field() }}
            <div class="form-row align-items-center">
                <div class="col-sm-6 my-1">
                    <label class="sr-only" for="site">Сайт</label>
                    <input type="text" name="site" class="form-control" id="site"
                           value="{{ request()->site }}" placeholder="Введите сайт">
                </div>
                <div class="col-sm-3 my-1">
                    <button type="submit" class="btn btn-primary">Проверка</button>
                </div>
            </div>
        </form>

        <div class="result">
            <h2>Результат</h2>

            <div class="messages">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Название проверки</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Текущее состояние</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr>
                                <td>{{ $message['title'] }}</td>
                                <td class="{{ $message['ok'] ? 'green' : 'red' }}">{{ $message['ok'] ? 'Ok' : 'Ошибка' }}</td>
                                <td>
                                    <p><i>Состояние.</i> {{ $message['status'] }}</p>
                                    <p><i>Рекомендации.</i> {{ $message['message'] }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>

@endsection