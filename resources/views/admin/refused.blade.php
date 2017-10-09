@extends('master3')

@section('content')
    <div class="col-2">
        <div class="container">
            <a href="{{route('rejected_loans_excel')}}" class="btn btn-primary">Export as xls</a>
        </div>

        <center><h2 style="color: #3D8DBB">Rejected Loans</h2></center>
        <hr>
        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            {{--<th>Package</th>--}}
            <th>Amount</th>
            {{--<th>Status</th>--}}
            {{--<th>Date</th>--}}
            <th></th>
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('admin_get_refused_loans')}}',

                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
//                        {data: 'pname', name: 'pname'},
                        {data: 'amount', name: 'amount'}
//                        {data: 'sname', name: 'status'},
//                        {data: 'created_at', name: 'date'},
//                        {data: '6', name: 'action'}
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

