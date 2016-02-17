<div class="col-md-6">
    <table class="table">
        <thead>
        <tr>
            <th>Date</th>
            <th>Course</th>
            <th>Score</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($rounds as $round)
            <tr>
                <td>
                    {{ $round->date->format('j F Y') }}
                </td>
                <td>
                    <a href="{{ route('courses.show', $round->course_slug) }}">
                        {{ $round->course_name }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('rounds.show', $round->id) }}">
                        {{ $round->total_strokes }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>