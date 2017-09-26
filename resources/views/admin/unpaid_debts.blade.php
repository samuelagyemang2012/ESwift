@extends('master3')

@section('content')
    <div class="col-2">
        {{--<div class="container">--}}
        <center><h2 style="color: #3D8DBB">Unpaid Debts</h2></center>
        <hr>
    </div>

    <table class="table" id="mytable">
        <thead>
        <th>ID</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Telephone</th>
        <th>Amount Borrowed</th>
        <th>Amount Paid</th>
        {{--<th>Half Loan Due</th>--}}
        {{--<th>Half Loan Due Date</th>--}}
        {{--<th>Full Loan Due</th>--}}
        <th>Date</th>
        <th></th>
        </thead>
    </table>

    @push('scripts')
    <script>
        $(function () {
            $('#mytable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('get_unpaid_debts')}}',

                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'telephone', name: 'telephone'},
                    {data: 'amount_borrowed', name: 'amount_borrowed'},
                    {data: 'amount_paid', name: 'amount_paid'},
//                    {data: 'half_debt', name: 'half_debt'},
//                    {data: 'created_at', name: 'created_at'},
//                    {data: 'total_debt', name: 'total_debt'},
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 6, name: 'action', render: function (data, type, full, meta) {

                        return '<a class="btn btn-sm btn-primary" href="debt/' + full['loan_id'] + '">Details</a>';
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