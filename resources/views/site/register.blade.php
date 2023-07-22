
<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@lang('messages.register_membership')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/uploads/Logo.png')}}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('lte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('lte/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @if(app()->getLocale() == 'en')
        <link rel="stylesheet" href="{{asset('lte/dist/css/style_ltr.css')}}">
    @endif
</head>
<body class="hold-transition register-page" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">

<div class="register-box">
    <div class="register-logo">
        <a href="../../index2.html"><b>
                <img src="{{asset('/uploads/Logo.png')}}" width="300">
            </b>
            @lang('messages.register_membership')
        </a>
    </div>
    @include('flash::message')
    <div class="card">
        @if(app()->getLocale() == 'en')
            <a href="{{ url('locale/ar')  }}" class="nav-link">
                    <span class="username username-hide-on-mobile">
                        عربى
                    </span>
            </a>
        @else
            <a href="{{  url('locale/en') }}" class="nav-link">
                    <span class="username username-hide-on-mobile">
                        English
                    </span>
            </a>
        @endif
        <div class="card-body register-card-body">
{{--            <p class="login-box-msg">@lang('messages.register_membership')</p>--}}

            <form action="{{route('registerNewUser')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}" placeholder="@lang('messages.first_name')">
                </div>
                @if ($errors->has('first_name'))
                    <span class="help-block">
                        <strong style="color: red;">{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
                <div class="input-group mb-3">
                    <input type="text" name="user_name" value="{{old('user_name')}}" class="form-control" placeholder="@lang('messages.user_name')">
                </div>
                @if ($errors->has('user_name'))
                    <span class="help-block">
                        <strong style="color: red;">{{ $errors->first('user_name') }}</strong>
                    </span>
                @endif
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="@lang('messages.email')">
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong style="color: red;">{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <div class="input-group mb-3">
                    <input type="text" name="entity" value="{{old('entity')}}" class="form-control" placeholder="@lang('messages.entity')">

                </div>
                @if ($errors->has('entity'))
                    <span class="help-block">
                        <strong style="color: red;">{{ $errors->first('entity') }}</strong>
                    </span>
                @endif
                <div class="input-group mb-3">
                    <select name="date_id" class="form-control">
                        <option disabled selected> @lang('messages.choose_event_date') </option>
                        @foreach($dates as $date)
                            <option value="{{$date->id}}"> {{$date->event_date->format('Y-m-d')}} </option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has('date_id'))
                    <span class="help-block">
                        <strong style="color: red;">{{ $errors->first('date_id') }}</strong>
                    </span>
                @endif

                <div class="input-group mb-3">
                    <select name="period_id" class="form-control" id="periods">
                        <option disabled selected> @lang('messages.choose_event_period') </option>

                    </select>
                </div>
                @if ($errors->has('period_id'))
                    <span class="help-block">
                        <strong style="color: red;">{{ $errors->first('period_id') }}</strong>
                    </span>
                @endif

                <div class="row">
                    <div class="col-8">
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">@lang('messages.register')</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{asset('lte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('select[name="date_id"]').on('change', function () {
            var id = $(this).val();
            var pm = '{{app()->getLocale() == 'ar' ? 'م' : 'pm'}}';
            var am = '{{app()->getLocale() == 'ar' ? 'ص' : 'am'}}';

            var from = '{{app()->getLocale() == 'ar' ? 'من' : 'from'}}';
            var to = '{{app()->getLocale() == 'ar' ? 'الي' : 'to'}}';
            $.ajax({
                url: '/get/periods/' + id,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    $('#periods').empty();
                    $('select[name="period_id"]').append("<option disabled selected> @lang('messages.choose_one') </option>");
                    $.each(data, function (index, periods) {
                        var hours_from = periods.start_at.slice(0, 2);
                        var minutes_from = periods.start_at.slice(3, 5);
                        var ampm = hours_from >= 12 ? pm : am;
                        hours_from = hours_from % 12;
                        hours_from = hours_from ? hours_from : 12;
                        minutes_from = minutes_from < 10 ? '0'+minutes_from : minutes_from;
                        var strTime_from = hours_from + ':' + minutes_from + ' ' + ampm;

                        /////////////////////// to //////////////////

                        var hours_to = periods.end_at.slice(0, 2);
                        var minutes_to = periods.end_at.slice(3, 5);
                        hours_to = hours_to % 12;
                        hours_to = hours_to ? hours_to : 12;
                        minutes_to = minutes_to < 10 ? '0'+minutes_to : minutes_to;
                        var strTime_to = hours_to + ':' + minutes_to + ' ' + ampm;

                        var time = from +' '+ '('+ strTime_from + ')' + ' ' + to + ' ' + '(' + strTime_to + ' ' + ')';

                        $('select[name="period_id"]').append('<option value="' + periods.id + '">' + time +'</option>');
                    });
                }
            });
        });
    });
</script>
</body>
</html>
