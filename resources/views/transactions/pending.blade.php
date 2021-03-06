@extends('master2')

@section('content')
    <div class="col-2">
        <center><h3 style="color:#3C8DBC">Pending Loans</h3>
            <hr>
        </center>
        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
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
                    ajax: '{{route('transactions_pending_loans')}}',

                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'amount', name: 'amount'},
                        {data: 'mobile_money_account', name: 'mobile_money_account'},
                        {data: 'created_at', name: 'created_at'},
                        {
                            data: '6', name: 'action', render: function (data, type, full, meta) {
                            console.log(full);
//                            var  s = full['0'];
                            return '<div class="btn-group">' +
//                                    '<a title="approve" class="btn btn-sm btn-primary" href="client/details/' + full['id'] + '">' +
//                                    '<i class="fa fa-question"></i>' +
//                                    '</a>' +
                                    '<a title="approve" class="btn btn-sm btn-success" href="/eswift/transactions/approve/' + full['amount'] + '/' + full['user_id'] + '/' + full['id'] + '/' + full['telephone'] + '">' +
                                    '<i class="fa fa-check"></i>' +
                                    '</a>' +
                                    '<a title="refuse" class="btn btn-sm btn-danger" href="/eswift/transactions/refuse/' + full['id'] + '/' + full['amount'] + '/' + full['telephone'] + '">' +
                                    '<i class="fa fa-close"></i>' +
                                    '</a>' +
                                    '</div>';
                        }
                        }
                    ]
                });
            })
            ;
        </script>
        @endpush
    </div>
@stop

@section('footer')

@stop

