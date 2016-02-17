@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2><a href="{{ route('users.show', [$user->id]) }}">{{ $user->name }}</a></h2>

                <h3>All Rounds</h3>

                <table class="table all-rounds-table">
                    <thead>
                    <tr>
                        <th>
                            <a href="{{ link_to_sortable_route('users.rounds', [$user->id, 'sort' => 'date', 'direction' => $direction]) }}">Date</a>

                            @if ($sort === 'date')
                                {!! sort_direction_html($direction) !!}
                            @endif
                        </th>
                        <th>
                            <a href="{{ link_to_sortable_route('users.rounds', [$user->id, 'sort' => 'course_name', 'direction' => $direction]) }}">Course</a>

                            @if ($sort === 'course_name')
                                {!! sort_direction_html($direction) !!}
                            @endif
                        </th>
                        <th>
                            <a href="{{ link_to_sortable_route('users.rounds', [$user->id, 'sort' => 'tee_type_name', 'direction' => $direction]) }}">Tees</a>

                            @if ($sort === 'tee_type_name')
                                {!! sort_direction_html($direction) !!}
                            @endif
                        </th>
                        <th>
                            <a href="{{ link_to_sortable_route('users.rounds', [$user->id, 'sort' => 'strokes', 'direction' => $direction]) }}">Score</a>

                            @if ($sort === 'strokes')
                                {!! sort_direction_html($direction) !!}
                            @endif
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($rounds as $round)
                        <tr>
                            <td>
                                <a href="{{ route('rounds.show', $round->id) }}">
                                    {{ $round->date->format('j F Y') }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('courses.show', $round->course_slug) }}">
                                    {{ $round->course_name }}
                                </a>
                            </td>
                            <td>
                                {{ $round->tee_type_name }}
                            </td>
                            <td>
                                {{ $round->strokes }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {!! $rounds->appends(['sort' => $sort, 'direction' => $direction])->render() !!}

            </div>
        </div>
    </div>

@endsection