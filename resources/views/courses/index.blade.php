@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2>All Courses</h2>

                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            <a href="{{ link_to_sortable_route('courses.index', ['sort' => 'name', 'direction' => $direction]) }}">Course</a>

                            @if ($sort === 'name')
                                {!! sort_direction_html($direction) !!}
                            @endif
                        </th>
                        <th>
                            <a href="{{ link_to_sortable_route('courses.index', ['sort' => 'par', 'direction' => $direction]) }}">Par</a>

                            @if ($sort === 'par')
                                {!! sort_direction_html($direction) !!}
                            @endif
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>
                                <a href="{{ route('courses.show', $course->slug) }}">{{ $course->name }}</a>
                            </td>
                            <td>{{ $course->par }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {!! $courses->appends(['sort' => $sort, 'direction' => $direction])->render() !!}

            </div>
        </div>
    </div>

@endsection
