@extends('master3')

@section('content')
    <div class="col-2">
        <center><h2 style="color: #3D8DBB">Pending Loans</h2></center>
        <hr>

        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Telephone</th>
            {{--<th>Package</th>--}}
            <th>Amount</th>
            <th>Mobile Network</th>
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
                    ajax: '{{route('admin_get_pending_loans')}}',

                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
//                            {data: 'pname', name: 'pname'},
                        {data: 'telephone', name: 'telephone'},
                        {data: 'amount', name: 'amount'},
                        {data: 'mobile_money_account', name: 'mobile_money_account'},
                        {data: 'created_at', name: 'created_at'},
                        {
                            data: '6', name: 'action', render: function (data, type, full, meta) {
//                            alert(full['mobile_money_account']);
//                            var  s = full['0'];
                            return '<div class="btn-group">' +
                                    '<a title="approve" class="btn btn-sm btn-success" href="/eswift/approve/' + full['amount'] + '/' + full['user_id'] + '/' + full['id'] + '/' + full['telephone'] + '">' +
                                    '<i class="fa fa-check"></i>' +
                                    '</a>' +
                                    '<a title="refuse" class="btn btn-sm btn-danger" href="/eswift/refuse/' + full['id'] + '/' + full['amount'] + '/' + full['telephone'] + '">' +
                                    '<i class="fa fa-close"></i>' +
                                    '</a>' +
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

