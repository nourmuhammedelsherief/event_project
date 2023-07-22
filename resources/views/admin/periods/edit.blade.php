@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.edit') @lang('messages.periods')
@endsection

@section('styles')

@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.edit') @lang('messages.periods') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/admin/home')}}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('periods.index')}}">
                                @lang('messages.periods')
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">@lang('messages.edit') @lang('messages.periods') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('periods.update' , $period->id)}}" method="post" enctype="multipart/form-data">
                            <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.date') </label>
                                    <select name="date_id" class="form-control" required>
                                        <option disabled selected> @lang('messages.choose_one') </option>
                                        @foreach($dates as $date)
                                            <option value="{{$date->id}}" {{$period->date_id == $date->id ? 'selected' : ''}}> {{$date->event_date->format('Y-m-d')}} </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('date_id'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('date_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.period_name') </label>
                                    <input name="name" type="text" class="form-control" value="{{$period->name}}" placeholder="@lang('messages.name')">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.period_start_at') </label>
                                    <input name="start_at" type="time" class="form-control" value="{{$period->start_at}}" placeholder="@lang('messages.start_at')">
                                    @if ($errors->has('start_at'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('start_at') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.period_end_at') </label>
                                    <input name="end_at" type="time" class="form-control" value="{{$period->end_at}}" placeholder="@lang('messages.end_at')">
                                    @if ($errors->has('end_at'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('end_at') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.period_people_count') </label>
                                    <input name="people_count" type="number" class="form-control" value="{{$period->people_count}}" placeholder="@lang('messages.period_people_count')">
                                    @if ($errors->has('people_count'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('people_count') }}</strong>
                                        </span>
                                    @endif
                                </div>


                            </div>
                            <!-- /.card-body -->
                            @method('PUT')
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('submit', 'form', function() {
                $('button').attr('disabled', 'disabled');
            });
        });
    </script>
@endsection
