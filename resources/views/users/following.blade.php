@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2><a href="{{ route('users.show', [$user->id]) }}">{{ $user->name }}</a></h2>

                <h3>Following</h3>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($following as $user)
                        <tr>
                            <td>
                                <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {!! $following->render() !!}

            </div>
        </div>
    </div>

@endsection
