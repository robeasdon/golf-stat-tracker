@extends('app')

@section('content')

    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <h2><a href="{{ route('courses.show', $course->slug) }}">{{ $course->name }}</a></h2>
            </div>

            <div class="col-md-6">

                <h3>Hole {{ $hole->number }}</h3>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Hole</th>
                        <th>Par</th>

                        @foreach ($course->teeSets as $teeSet)
                            <th>{{ $teeSet->teeType->name }}</th>
                        @endforeach

                        <th>SI</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $hole->number }}</td>
                        <td>{{ $hole->par }}</td>

                        @foreach ($hole->tees as $tee)
                            <td>{{ $tee->yards }}</td>
                        @endforeach

                        <td>{{ $hole->si_mens }}</td>
                    </tr>
                    </tbody>
                </table>

            </div>


            <div class="col-md-6">

                <h3>Your Stats</h3>

                @if ($stats && $stats->times_played > 0)

                    <table class="table">
                        <tbody>
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
                            <td>Total Double Bogies</td>
                            <td>{{ $stats->total_double_bogies }}</td>
                        </tr>
                        <tr>
                            <td>Average Score</td>
                            <td>{{ round($stats->avg_strokes, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Average Putts</td>
                            <td>{{ round($stats->avg_putts, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Best Score</td>
                            <td>{{ $stats->best_score }}</td>
                        </tr>
                        </tbody>
                    </table>

                @else
                    <div class="alert alert-info" role="alert">
                        <p>You have not played on this course yet.</p>
                    </div>
                @endif

            </div>

        </div>
    </div>

@endsection
