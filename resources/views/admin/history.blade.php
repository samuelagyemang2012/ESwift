@extends('master3')

@section('content')
    <div class="col-2">
        {{--<div class="container">--}}
        <center><h2 style="color: #3D8DBB">Payment History</h2></center>
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
        <th>Account Name</th>
        <th>Amount Paid (GHC)</th>
        <th>Transaction ID</th>
        <th>Purpose</th>
        <th>Recorded By</th>
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
                ajax: '{{route('get_history')}}',

                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'telephone', name: 'telephone'},
                    {data: 'amount_paid', name: 'amount_paid'},
//                    {data: 'last_name', name: 'last_name'},
                    {data: 'transaction_id', name: 'transaction_id'},
                    {data: 'purpose', name: 'purpose'},
                    {data: 'by', name: 'by'},
//                    {data: 'half_debt', name: 'half_debt'},
//                    {data: 'created_at', name: 'created_at'},
//                    {data: 'total_debt', name: 'total_debt'},
                    {data: 'created_at', name: 'created_at'}
                ],

                "order": [[5, "desc"]]
            });
        });
    </script>
    @endpush
    {{--</div>--}}
@stop