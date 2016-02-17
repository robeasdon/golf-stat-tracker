@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2><a href="{{ route('users.show', [$user->id]) }}">{{ $user->name }}</a></h2>

                <h3>Feed</h3>

                <table class="table">
                    <tbody>
                    @foreach($feed as $round)
                        <tr>
                            <td>
                                <a href="{{ route('users.show', $round->user->id) }}">
                                    {{ $round->user->name }}
                                </a>

                                played a round at

                                <a href="{{ route('courses.show', $round->teeSet->course->slug) }}">
                                    {{ $round->teeSet->course->name }}
                                </a>

                                <a href="{{ route('rounds.show', $round->id) }}">
                                    {{ $round->date->diffForHumans() }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {!! $feed->render() !!}

            </div>
        </div>
    </div>

@endsection

