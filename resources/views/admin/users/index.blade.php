@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.members')
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('lte/sweetalert.css') }}">
    <!-- Theme style -->
@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        @lang('messages.members')
                        (
                        <span>
                            @if($status == 'waiting')
                                @lang('messages.waiting_accept')
                            @elseif($status == 'accepted')
                                @lang('messages.accepted')
                            @elseif($status == 'rejected')
                                @lang('messages.rejected')
                            @endif
                        </span>
                        )
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/admin/home')}}">
                                @lang('messages.control_panel')
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('users.index' , $status)}}"></a>
                            @lang('messages.members')
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash::message')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="group-checkable"
                                               data-set="#sample_1 .checkboxes"/>
                                        <span></span>
                                    </label>
                                </th>
                                <th></th>
                                <th>@lang('messages.date')</th>
                                <th>@lang('messages.first_name')</th>
                                <th>@lang('messages.user_name')</th>
                                <th>@lang('messages.email')</th>
                                <th>@lang('messages.period_name')</th>
                                <th>@lang('messages.operations')</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach($users as $user)
                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" value="1"/>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td><?php echo ++$i ?></td>
                                    <td>
                                        {{$user->period->date->event_date->format('Y-m-d')}}
                                    </td>
                                    <td> {{$user->user->first_name}} </td>
                                    <td> {{$user->user->user_name}} </td>
                                    <td>
                                        <a href="mailTo:{{$user->user->email}}">{{$user->user->email}}</a>
                                    </td>
                                    <td>
                                        {{$user->period->name}}
                                    </td>
                                    <td>
                                        @if($status != 'accepted')
                                            <a href="{{route('users.activate' , [$user->id , 'accepted'])}}"
                                               class="btn btn-success"> @lang('messages.accept') </a>
                                        @endif
                                        @if($status != 'rejected')
                                            <a href="{{route('users.activate' , [$user->id , 'rejected'])}}"
                                               class="btn btn-warning"> @lang('messages.reject') </a>
                                        @endif
                                        <a class="delete_data btn btn-danger" data="{{ $user->id }}"
                                           data_name="{{ $user->user->first_name }}">
                                            <i class="fa fa-key"></i> @lang('messages.delete')
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                {{$users->links()}}
                <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>


@endsection

@section('scripts')

    <script src="{{asset('lte/dist/js/adminlte.min.js')}}"></script>
    <script src="{{asset('lte/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{ URL::asset('lte/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('lte/ui-sweetalert.min.js') }}"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('body').on('click', '.delete_data', function () {
                var id = $(this).attr('data');
                var swal_text = '{{trans('messages.delete')}} ' + $(this).attr('data_name');
                var swal_title = "{{trans('messages.deleteSure')}}";

                swal({
                    title: swal_title,
                    text: swal_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-warning",
                    confirmButtonText: "{{trans('messages.sure')}}",
                    cancelButtonText: "{{trans('messages.close')}}"
                }, function () {

                    window.location.href = "{{ url('/') }}" + "/admin/users/delete/" + id;

                });

            });
        });
    </script>
@endsection
