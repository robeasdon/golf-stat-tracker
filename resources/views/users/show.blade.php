@extends('app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h2 class="pull-left">{{ $user->name }}</h2>

                @if (Auth::check() && Auth::id() != $user->id)

                    <div class="pull-right" style="margin-top: 20px;">
                        @if (Auth::user()->isFollowing($user))
                            {!! Form::open(['route' => ['users.unfollow', $user->id], 'style' => 'display:inline-block;']) !!}
                                {!! Form::submit('Unfollow', ['class' => 'btn btn-default']) !!}
                            {!! Form::close() !!}
                        @else
                            {!! Form::open(['route' => ['users.follow', $user->id], 'style' => 'display:inline-block;']) !!}
                                {!! Form::submit('Follow', ['class' => 'btn btn-default']) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>

                @endif

            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <h3>Par 3</h3>

                <div id="par3-chart" class="par-chart"></div>
            </div>
            <div class="col-sm-4">
                <h3>Par 4</h3>

                <div id="par4-chart" class="par-chart"></div>
            </div>
            <div class="col-sm-4">
                <h3>Par 5</h3>

                <div id="par5-chart" class="par-chart"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">

                @include('partials.latest-rounds', [$latestRounds, $user])

                @include('partials.best-rounds', [$bestRounds, $user])

            </div>

            <div class="col-md-6">

                @include('partials.stats', [$stats, $user])

            </div>
        </div>

    </div>

@endsection

@section('scripts')

    <script src="{{ elixir('js/d3.min.js') }}"></script>
    <script src="{{ elixir('js/modules/par-chart.js') }}"></script>
    <script>
        var data = {!! json_encode($chartData['par3']) !!};

        ParChart.init(data, {
            container: '#par3-chart'
        });

        data = {!! json_encode($chartData['par4']) !!};

        ParChart.init(data, {
            container: '#par4-chart'
        });

        data = {!! json_encode($chartData['par5']) !!};

        ParChart.init(data, {
            container: '#par5-chart'
        });
    </script>

@endsection
