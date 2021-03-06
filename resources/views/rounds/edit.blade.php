@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @include('partials.errors')

                {!! Form::open(['method' => 'PATCH', 'route' => ['rounds.update', $round->id], 'class' =>'form-horizontal']) !!}

                <div class="form-group">
                    <div class="col-md-4 @if ($errors->has('course')) has-error @endif">
                        <h4>Course</h4>

                        {!! Form::select('course', $courses, $round->teeSet->course->id, ['class' => 'form-control']) !!}

                    </div>
                    <div class="col-md-2 @if ($errors->has('teeType')) has-error @endif">
                        <h4>Tees</h4>

                        {!! Form::select('teeType', $teeTypes, $round->teeSet->teeType->id, ['class' => 'form-control']) !!}

                    </div>
                    <div class="col-md-6">
                        <h4>Date</h4>

                        <div class="row">
                            <div class="col-xs-4 @if ($errors->has('day')) has-error @endif">
                                {!! Form::text('day', $round->date->day, ['class' => 'form-control', 'placeholder' => 'DD', 'maxlength' => '2']) !!}
                            </div>

                            <div class="col-xs-4 @if ($errors->has('month')) has-error @endif">
                                {!! Form::text('month', $round->date->month, ['class' => 'form-control', 'placeholder' => 'MM', 'maxlength' => '2']) !!}
                            </div>

                            <div class="col-xs-4 @if ($errors->has('year')) has-error @endif">
                                {!! Form::text('year', $round->date->year, ['class' => 'form-control', 'placeholder' => 'YYYY', 'maxlength' => '4']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <h4>Scores</h4>

                        <table class="table table-create-round table-fixed">
                            <tbody>
                            <tr>
                                <td>Hole</td>
                                @for ($i = 1; $i <= 18; $i++)
                                    <td>{{ $i }}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>Score</td>
                                @for ($i = 1; $i <= 18; $i++)
                                    <td @if ($errors->has('scores.'.$i)) class="has-error" @endif>
                                        {!! Form::text("scores[$i]", $round->scores[$i-1]->strokes, ['class' => 'form-control scores-input', 'maxlength' => '2']) !!}
                                    </td>
                                @endfor
                            </tr>
                            <tr>
                                <td>Putts</td>
                                @for ($i = 1; $i <= 18; $i++)
                                    <td @if ($errors->has('putts.'.$i)) class="has-error" @endif>
                                        {!! Form::text("putts[$i]", $round->scores[$i-1]->putts, ['class' => 'form-control putts-input', 'maxlength' => '2']) !!}
                                    </td>
                                @endfor
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @include('rounds.partials.totals')

                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::submit('Edit Round', ['class' => 'btn btn-default']); !!}
                    </div>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{ elixir('js/modules/round-validation.js') }}"></script>

@endsection