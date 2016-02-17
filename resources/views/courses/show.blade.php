@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-6">

                        <h2>{{ $course->name }}</h2>

                        <table class="table table-totals">
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
                                @foreach ($course->holes as $hole)
                                    <tr>
                                        <td><a href="{{ route('courses.holes.show', [$course->slug, $hole->number]) }}">{{ $hole->number }}</a></td>
                                        <td>{{ $hole->par }}</td>

                                        @foreach ($hole->tees as $tee)
                                            <td>{{ $tee->yards }}</td>
                                        @endforeach

                                        <td>{{ $hole->si_mens }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>Total</td>
                                    <td>{{ $course->totalPar() }}</td>

                                    @foreach ($course->teeSets as $teeSet)
                                        <td>{{ $teeSet->totalYards() }}</td>
                                    @endforeach

                                    <td>Total</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    @if ($user)
                        <div class="col-md-6">

                            @include('partials.stats', [$stats, $user])

                            @include('partials.best-rounds', [$bestRounds, $user])

                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>

@endsection
