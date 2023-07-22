@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.settings')
@endsection

@section('styles')

@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.edit') @lang('messages.settings') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/admin/home')}}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('settings.index')}}">
                                @lang('messages.settings')
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
                @include('flash::message')
                <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">@lang('messages.edit') @lang('messages.settings') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('store_setting' , $setting->id)}}" method="post" enctype="multipart/form-data">
                            <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.auto_active') </label>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <select name="auto_active" class="form-control">
                                                <option value="true" {{$setting->auto_active == 'true' ? 'selected' : ''}}> @lang('messages.yes') </option>
                                                <option value="false" {{$setting->auto_active == 'false' ? 'selected' : ''}}> @lang('messages.no') </option>
                                            </select>
                                            @if ($errors->has('auto_active'))
                                                <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('auto_active') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
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
