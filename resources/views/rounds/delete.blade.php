@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2>Confirm you want to delete?</h2>

                {!! Form::open(['method' => 'DELETE', 'route' => ['rounds.destroy', $round->id], 'style' => 'display:inline-block;']) !!}
                {!! Form::submit('Delete Round', ['class' => 'btn btn-default']) !!}
                {!! Form::close() !!}

                <a href="{{ route('rounds.show', $round->id) }}" class="btn btn-default">Cancel</a>

            </div>
        </div>
    </div>

@endsection