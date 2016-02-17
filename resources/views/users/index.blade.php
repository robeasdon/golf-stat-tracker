@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2>All Users</h2>

                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            <a href="{{ link_to_sortable_route('users.index', ['sort' => 'name', 'direction' => $direction]) }}">Name</a>

                            @if ($sort === 'name')
                                {!! sort_direction_html($direction) !!}
                            @endif
                        </th>
                        <th>
                            <a href="{{ link_to_sortable_route('users.index', ['sort' => 'created_at', 'direction' => $direction]) }}">Registered</a>

                            @if ($sort === 'created_at')
                                {!! sort_direction_html($direction) !!}
                            @endif
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
                            </td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {!! $users->appends(['sort' => $sort, 'direction' => $direction])->render() !!}

            </div>
        </div>
    </div>

@endsection
