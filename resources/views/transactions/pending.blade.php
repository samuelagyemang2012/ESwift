@extends('master2')

@section('content')
    <div class="col-2">
        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Package</th>
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
                        {data: 'first_name', name: 'fname'},
                        {data: 'last_name', name: 'lname'},
                        {data: 'pname', name: 'package'},
                        {data: 'amount', name: 'amount'},
                        {data: 'mobile_money_account', name: 'status'},
                        {data: 'created_at', name: 'date'},
                        {
                            data: '6', name: 'action', render: function (data, type, full, meta) {
                            console.log(full);
//                            var  s = full['0'];
                            return '<div class="btn-group">' +
                                    '<a title="approve" class="btn btn-sm btn-primary" href="client/details/' + full['id'] + '">' +
                                    '<i class="fa fa-question"></i>' +
                                    '</a>' +
                                    '<a title="approve" class="btn btn-sm btn-success" href="/transactions/approve/' + full['id'] + '/'+ full['amount'] +'">' +
                                    '<i class="fa fa-check"></i>' +
                                    '</a>' +
                                    '<a title="refuse" class="btn btn-sm btn-danger" href="/transactions/refuse/' + full['id'] + '">' +
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

