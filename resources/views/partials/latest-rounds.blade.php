<div class="row">
    <div class="col-md-12">

        <h3 class="pull-left">Latest Rounds</h3>

        <a href="{{ route('users.rounds', [$user->id, 'sort' => 'date', 'direction' => 'desc']) }}" class="pull-right" style="margin-top:26px;">View all</a>

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
    @foreach ($latestRounds as $round)
        <tr>
            <td>
                <a href="{{ route('rounds.show', $round->id) }}">
                    {{ $round->date->format('j F Y') }}
                </a>
            </td>
            <td>
                <a href="{{ route('courses.show', $round->teeSet->course->slug) }}">
                    {{ $round->teeSet->course->name }}
                </a>
            </td>
            <td>{{ $round->totalStrokes() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>