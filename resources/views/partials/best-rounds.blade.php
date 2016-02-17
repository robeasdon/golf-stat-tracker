<div class="row">
    <div class="col-md-12">

        <h3 class="pull-left">Best Rounds</h3>

        <a href="{{ route('users.rounds', [$user->id, 'sort' => 'strokes', 'direction' => 'asc']) }}" class="pull-right"
           style="margin-top:26px;">View all</a>

    </div>
</div>

<table class="table">
    <thead>
    <tr>
        <th>Date</th>
        <th>Course</th>
        <th>Score</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($bestRounds as $round)
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
            <td>{{ $round->total_strokes }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3">No rounds played.</td>
        </tr>
    @endforelse
    </tbody>
</table>