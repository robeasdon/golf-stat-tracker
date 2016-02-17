@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2>Compare</h2>

                @if ($stats['user1']->rounds_played > 0 && $stats['user2']->rounds_played > 0)

                    <div class="row">
                        <div class="col-md-6">
                            <h2>
                                <a href="{{ route('users.show', $users['user1']->id) }}">
                                    {{ $users['user1']->name }}
                                </a>
                            </h2>
                        </div>
                        <div class="col-md-6">
                            <h2>
                                <a href="{{ route('users.show', $users['user2']->id) }}">
                                    {{ $users['user2']->name }}
                                </a>
                            </h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Player Stats</h3>
                        </div>
                    </div>

                    <div class="row">
                        @include('compare.partials.stats', ['user1' => $stats['user1'], 'user2' => $stats['user2']])
                        @include('compare.partials.stats', ['user1' => $stats['user2'], 'user2' => $stats['user1']])
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Best Rounds</h3>
                        </div>
                    </div>

                    <div class="row">
                        @include('compare.partials.best-rounds', ['rounds' => $bestRounds['user1']])
                        @include('compare.partials.best-rounds', ['rounds' => $bestRounds['user2']])
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger">No stats to compare</div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection
