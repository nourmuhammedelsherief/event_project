<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @lang('messages.user_details')
    </title>
    <link rel="icon" type="image/x-icon" href="{{asset('/uploads/Logo.png')}}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('lte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('lte/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="container">

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="callout callout-info">
                            {!! QrCode::size(80)->generate(url('/barcode/details/' . $user->id)) !!}
                        </div>

                    @include('flash::message')
                    <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        @if(app()->getLocale() == 'en')
                                            <a href="{{ url('locale/ar')  }}" class="nav-link">
                                                <span class="username username-hide-on-mobile">
                                                    <i class="fas fa-globe"></i>
                                                </span>
                                            </a>
                                        @else
                                            <a href="{{  url('locale/en') }}" class="nav-link">
                                                <span class="username username-hide-on-mobile">
                                                    <i class="fas fa-globe"></i>
                                                </span>
                                            </a>
                                        @endif
                                        <small class="float-right">
                                            @lang('messages.event_date') :
                                            {{$user->period->date->event_date->format('Y-m-d')}}
                                        </small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <!-- /.row -->

                            <!-- Table row -->
                            <h2 class="text-center">
                                @lang('messages.user_details')
                            </h2>
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>

                                            {{--                                            <th>@lang('messages.date')</th>--}}
                                            <th>@lang('messages.first_name')</th>
                                            <th>@lang('messages.user_name')</th>
                                            <th>@lang('messages.email')</th>
                                            <th>@lang('messages.entity')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="odd gradeX">
                                            {{--                                            <td>--}}
                                            {{--                                                {{$user->period->date->event_date->format('Y-m-d')}}--}}
                                            {{--                                            </td>--}}
                                            <td> {{$user->user->first_name}} </td>
                                            <td> {{$user->user->user_name}} </td>
                                            <td>
                                                <a href="mailTo:{{$user->user->email}}">{{$user->user->email}}</a>
                                            </td>
                                            <td>
                                                {{$user->user->entity}}
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <hr>
                            <h2 class="text-center">
                                @lang('messages.event_details')
                            </h2>
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('messages.period_name')</th>
                                            <th>@lang('messages.period_from')</th>
                                            <th>@lang('messages.period_to')</th>
                                            <th>@lang('messages.status')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="odd gradeX">
                                            <td> {{$user->period->name}} </td>
                                            <td> {{ \Carbon\Carbon::parse($user->period->start_at)->isoFormat('h:mm a')}} </td>
                                            <td> {{ \Carbon\Carbon::parse($user->period->end_at)->isoFormat('h:mm a')}} </td>
                                            <td>
                                                @if($user->status == 'waiting')
                                                    <a href="#"
                                                       class="btn btn-warning">@lang('messages.waiting_accept')</a>
                                                @elseif($user->status == 'accepted')
                                                    <a href="#" class="btn btn-success">
                                                        @lang('messages.accepted')
                                                    </a>
                                                @elseif($user->status == 'rejected')
                                                    <a href="#" class="btn btn-danger">
                                                        @lang('messages.rejected')
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            @if($user->attendance == 'false')
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-6">
                                        <form method="post" action="{{route('confirm_attendance' , $user->id)}}">
                                            @csrf
                                            <div class="form-group">
                                                <div class="col-8">
                                                    <input name="attendance_code" type="text" class="form-control"
                                                           value="{{old('attendance_code')}}"
                                                           placeholder="@lang('messages.attendance_code')" required>
                                                    @if ($errors->has('attendance_code'))
                                                        <span class="help-block">
                                                    <strong
                                                        style="color: red;">{{ $errors->first('attendance_code') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <button type="submit"
                                                        class="btn btn-primary btn-block btn-flat">@lang('messages.confirm')</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>
                            @endif
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </section>
    </div>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('lte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('lte/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('lte/dist/js/demo.js')}}"></script>
</body>
</html>
