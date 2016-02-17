<div class="row">
    <div class="col-md-12">
        <h3 class="pull-left">Stats</h3>

        @if (Auth::check() && Auth::id() !== $user->id)
            <a href="{{ route('compare', ['user' => Auth::id(), 'to' => $user->id]) }}" class="pull-right" style="margin-top:26px;">Compare stats</a>
        @endif
    </div>
</div>

@if ($stats->rounds_played > 0)

    <table class="table">
        <tr>
            <td>Rounds Played</td>
            <td>{{ $stats->rounds_played }}</td>
        </tr>
        <tr>
            <td>Total Eagles</td>
            <td>{{ $stats->total_eagles }}</td>
        </tr>
        <tr>
            <td>Total Birdies</td>
            <td>{{ $stats->total_birdies }}</td>
        </tr>
        <tr>
            <td>Total Pars</td>
            <td>{{ $stats->total_pars }}</td>
        </tr>
        <tr>
            <td>Total Bogies</td>
            <td>{{ $stats->total_bogies }}</td>
        </tr>
        <tr>
            <td>Total Doubles</td>
            <td>{{ $stats->total_double_bogies }}</td>
        </tr>
        <tr>
            <td>Average Score</td>
            <td>{{ round($stats->avg_strokes, 2) }}</td>
        </tr>
        <tr>
            <td>Average Putts Per Hole</td>
            <td>{{ round($stats->avg_putts_per_hole, 2) }}</td>
        </tr>
        <tr>
            <td>Average Score Par 3</td>
            <td>{{ round($stats->avg_strokes_par3, 2) }}</td>
        </tr>
        <tr>
            <td>Average Score Par 4</td>
            <td>{{ round($stats->avg_strokes_par4, 2) }}</td>
        </tr>
        <tr>
            <td>Average Score Par 5</td>
            <td>{{ round($stats->avg_strokes_par5, 2) }}</td>
        </tr>
    </table>

@else

    <div class="alert alert-info" role="alert">
        <p>You have not played on this course yet.</p>
    </div>

@endif