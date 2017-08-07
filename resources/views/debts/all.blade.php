@extends('master3')

@section('content')
    <div class="col-2">
        {{--<div class="container">--}}
            <center><h2 style="color: #3D8DBB">Debts</h2></center>
            <hr>
        </div>

        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Telephone</th>
            <th>Amount</th>
            <th>Amount Paid</th>
            <th>Date</th>
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('get_debts')}}',

                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'telephone', name: 'telephone'},
                        {data: 'amount_borrowed', name: 'amount_borrowed'},
                        {data: 'amount_paid', name: 'amount_paid'},
                        {data: 'created_at', name: 'created_at'}
                    ]
                });
            })
            ;
        </script>
        @endpush
    </div>
@stop