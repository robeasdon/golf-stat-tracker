@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2>All Rounds</h2>

                <table class="table all-rounds-table">
                    <thead>
                    <tr>
                        <th>
                            <a href="{{ link_to_sortable_route('rounds.index', ['sort' => 'user_name', 'direction' => $direction]) }}">Player</a>

                            @if ($sort === 'user_name')
                                {!! sort_direction_html($direction) !!}
                            @endif
                        </th>
                        <th>
                            <a href="{{ link_to_sortable_route('rounds.index', ['sort' => 'date', 'direction' => $direction]) }}">Date</a>

                            @if ($sort === 'date')
                                {!! sort_direction_html($direction) !!}
                            @endif
                        </th>
                        <th>
                            <a href="{{ link_to_sortable_route('rounds.index', ['sort' => 'course_name', 'direction' => $direction]) }}">Course</a>

                            @if ($sort === 'course_name')
                                {!! sort_direction_html($direction) !!}
                            @endif
                        </th>
                        <th>
                            <a href="{{ link_to_sortable_route('rounds.index', ['sort' => 'tee_type_name', 'direction' => $direction]) }}">Tees</a>

                            @if ($sort === 'tee_type_name')
                                {!! sort_direction_html($direction) !!}
                            @endif
                        </th>
                        <th>
                            <a href="{{ link_to_sortable_route('rounds.index', ['sort' => 'strokes', 'direction' => $direction]) }}">Score</a>

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
                                <a href="{{ route('users.show', $round->user_id) }}">{{ $round->user_name }}</a>
                            </td>
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