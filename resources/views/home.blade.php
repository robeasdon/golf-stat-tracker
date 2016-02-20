@extends('app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-12">

                <h3>Trends</h3>

                <div id="trends-chart"></div>

            </div>
        </div>

        <div class="row">

            <div class="col-md-12">

                <table class="table trends-table">
                    <tbody>
                    <tr>
                        <td>Strokes</td>
                        <td>{{ sprintf("%+0.2f", $trends['strokes']) }} {!! trends_arrow_html($trends['strokes']) !!}</td>
                        <td>Putts</td>
                        <td>{{ sprintf("%+0.2f", $trends['putts']) }} {!! trends_arrow_html($trends['putts']) !!}</td>
                        <td>Par 3</td>
                        <td>{{ sprintf("%+0.2f", $trends['strokesPar3']) }} {!! trends_arrow_html($trends['strokesPar3']) !!}</td>
                        <td>Par 4</td>
                        <td>{{ sprintf("%+0.2f", $trends['strokesPar4']) }} {!! trends_arrow_html($trends['strokesPar4']) !!}</td>
                        <td>Par 5</td>
                        <td>{{ sprintf("%+0.2f", $trends['strokesPar5']) }} {!! trends_arrow_html($trends['strokesPar5']) !!}</td>
                    </tr>
                    </tbody>
                </table>

            </div>

        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="row">
                    <div class="col-md-12">

                        <h3 class="pull-left">Feed</h3>

                        <a href="{{ route('users.feed', $user->id) }}" class="pull-right" style="margin-top:26px;">View all</a>

                    </div>
                </div>

                <table class="table">
                    <tbody>
                    @foreach($feed as $round)
                        <tr>
                            <td>
                                <a href="{{ route('users.show', $round->user->id) }}">
                                    {{ $round->user->name }}
                                </a>

                                played a round at

                                <a href="{{ route('courses.show', $round->teeSet->course->slug) }}">
                                    {{ $round->teeSet->course->name }}
                                </a>

                                <a href="{{ route('rounds.show', $round->id) }}">
                                    {{ $round->date->diffForHumans() }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            <div class="col-md-6">

                @include('partials.latest-rounds', [$latestRounds, $user])

            </div>

        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{ elixir('js/d3.min.js') }}"></script>
    <script src="{{ elixir('js/modules/trends-chart.js') }}"></script>
    <script>
        var data = {!! json_encode($chartData) !!};

        TrendsChart.init(data, {
            container: '#trends-chart'
        });
    </script>

@endsection
