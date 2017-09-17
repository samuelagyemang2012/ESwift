@extends('master4')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4">
                @if (session('status'))
                    <div class="alert alert-success">
                        <p>{{ session('status') }}</p>
                    </div>
                @endif
            </div>

            <div class="col-sm-4"></div>
        </div>
    </div>

    <div class="col-2">
        <center><h2 style="color: #3D8DBB">Rates</h2></center>
        <hr>
        <table class="table" id="mytable">
            <thead>
            {{--<th>ID</th>--}}
            <th>Name</th>
            <th>Rate (%)</th>
            <th>Last Changed</th>
            <th></th>
            {{--<th>Status</th>--}}
            {{--<th>Date</th>--}}
            {{--<th>Actions</th>--}}
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('super_admin_home')}}',

                    columns: [
//                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'rate', name: 'rate'},
                        {data: 'updated_at', name: 'updated_at'},
//                        {data: 'amount', name: 'amount'},
//                        {data: 'sname',name:'sname'},
//                        {data: 'created_at', name: 'created_at'},
                        {
                            data: '6', name: 'action', render: function (data, type, full, meta) {

                            return '<div class="btn-group">' +
                                    '<a class="btn btn-sm btn-primary" href="rate/' + full['id'] + '">' +
                                    'Edit' +
                                    '</a>' +
//                                    '<a title="approve" class="btn btn-sm btn-success" href="/transactions/approve/' + full['id'] + '/'+ full['amount'] +'/'+ full['user_id']+'/'+full['id']+'/'+full['telephone'] +'">' +
//                                    '<i class="fa fa-check"></i>' +
//                                    '</a>' +
//                                    '<a title="refuse" class="btn btn-sm btn-danger" href="/transactions/refuse/' + full['id'] + '">' +
//                                    '<i class="fa fa-close"></i>' +
//                                    '</a>' +
                                    '</div>';
                        }
                        }
                    ]
                });
            });
        </script>
        @endpush
    </div>
@stop

@section('footer')

@stop

