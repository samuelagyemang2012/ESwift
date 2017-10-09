@extends('master3')

@section('content')
    <div class="col-2">
        {{--<div class="container">--}}
        <a href="{{route('unpaid_excel')}}" class="btn btn-primary">Export as xls</a>
        <center><h2 style="color: #3D8DBB">Unpaid Debts</h2></center>
        <hr>
    </div>

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

    <table class="table" id="mytable">
        <thead>
        <th>ID</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Telephone</th>
        <th>Total Debt</th>
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
                    {data: 'total_debt', name: 'total_debt'},
                    {data: 'amount_paid', name: 'amount_paid'},
//                    {data: 'half_debt', name: 'half_debt'},
//                    {data: 'created_at', name: 'created_at'},
//                    {data: 'total_debt', name: 'total_debt'},
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 6, name: 'action', render: function (data, type, full, meta) {

                        return '<div class="btn-group">' +
                                ' <a class="btn btn-sm btn-primary" href="/debts/' + full['loan_id'] + '">Details</a>' +
                                ' <a class="btn btn-sm btn-primary" href="/confirm_payment/' + full['loan_id'] + '/' + full['id'] + '">Confirm Payment</a>' +
                                '</div>';
                    }
                    }
                ],

                "order": [[6, "desc"]]
            });
        });
    </script>
    @endpush
    {{--</div>--}}
@stop