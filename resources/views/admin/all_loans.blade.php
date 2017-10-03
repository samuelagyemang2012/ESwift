@extends('master3')

@section('content')

    <div class="col-2">
        <center><h2 style="color: #3D8DBB">All Loans</h2></center>
        <hr>
        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Telephone</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('admin_get_all_loans')}}',

                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'telephone', name: 'telephone'},
                        {data: 'amount', name: 'amount'},
                        {data: 'sname', name: 'sname'},
                        {data: 'created_at', name: 'created_at'},
                        {
                            data: '6', name: 'action', render: function (data, type, full, meta) {

                            return '<div class="btn-group">' +
                                    '<a class="btn btn-sm btn-primary" href="client/details/' + full['user_id'] + '">' +
                                    'Details' +
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
                    ],

                    "order": [[6, "asc"]]
                });
            });
        </script>
        @endpush
    </div>
@stop

@section('footer')

@stop

