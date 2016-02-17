@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="pull-left">Scorecard</h2>

                        <div class="pull-right" style="margin-top: 20px;">
                            @if (Auth::id() == $round->user->id)
                                <a href="{{ route('rounds.edit', $round->id) }}" class="btn btn-default">Edit Round</a>
                                <a href="{{ route('rounds.delete', $round->id) }}" class="btn btn-default">Delete Round</a>
                            @endif
                        </div>
                    </div>
                </div>

                <ul class="text-muted list-unstyled list-inline">
                    <li><a href="{{ route('users.show', [$round->user->id]) }}">{{ $round->user->name }}</a></li>
                    <li><a href="{{ route('courses.show', [$round->teeSet->course->slug]) }}">{{ $round->teeSet->course->name }}</a></li>
                    <li>{{ $round->teeSet->teeType->name }} tees</li>
                    <li>{{ $round->date->format('j F Y') }}</li>
                </ul>

                <table class="table scorecard-table">
                    <tbody>
                    <tr>
                        <td>Hole</td>
                        @foreach ($round->scores as $score)
                            <td>{{ $score->hole->number }}</td>
                        @endforeach
                        <td>Total</td>
                    </tr>
                    <tr>
                        <td>Par</td>
                        @foreach ($round->scores as $score)
                            <td>{{ $score->hole->par }}</td>
                        @endforeach
                        <td>{{ $round->teeSet->course->totalPar() }}</td>
                    </tr>
                    <tr>
                        <td>Score</td>
                        @foreach ($round->scores as $score)
                            @if($score->strokes - $score->hole->par < 0)
                                <td class="bg-success">{{ $score->strokes }}</td>
                            @elseif($score->strokes - $score->hole->par > 0)
                                <td class="bg-danger">{{ $score->strokes }}</td>
                            @else
                                <td>{{ $score->strokes }}</td>
                            @endif
                        @endforeach
                        <td>{{ $round->totalStrokes() }}</td>
                    </tr>
                    <tr>
                        <td>+/-</td>
                        <?php $scoreToPar = 0; ?>
                        @foreach ($round->scores as $score)
                            <?php $scoreToPar += $score->strokes - $score->hole->par; ?>
                            @if ($scoreToPar === 0)
                                <td>E</td>
                            @else
                                <td>{{ sprintf('%+d', $scoreToPar) }}</td>
                            @endif
                        @endforeach
                        @if ($scoreToPar === 0)
                            <td>E</td>
                        @else
                            <td>{{ sprintf('%+d', $scoreToPar) }}</td>
                        @endif
                    </tr>
                    </tbody>
                </table>

                <h2>Totals</h2>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Putts</th>
                        <th>Birdies</th>
                        <th>Pars</th>
                        <th>Bogies</th>
                        <th>Doubles</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $round->totalPutts() }}</td>
                        <td>{{ $round->totalBirdies() }}</td>
                        <td>{{ $round->totalPars() }}</td>
                        <td>{{ $round->totalBogies() }}</td>
                        <td>{{ $round->totalDoubleBogies() }}</td>
                    </tr>
                    </tbody>
                </table>

                <h2>Averages</h2>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Putts per Hole</th>
                        <th>Score Par 3</th>
                        <th>Score Par 4</th>
                        <th>Score Par 5</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ round($round->averagePutts(), 2) }}</td>
                        <td>{{ round($round->averageStrokesPar(3), 2) }}</td>
                        <td>{{ round($round->averageStrokesPar(4), 2) }}</td>
                        <td>{{ round($round->averageStrokesPar(5), 2) }}</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection
