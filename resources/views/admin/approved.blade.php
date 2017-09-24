@extends('master3')

@section('content')
    <div class="col-2">
        <center><h2 style="color: #3D8DBB">Approved Loans</h2></center>
        <hr>
        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Amount</th>
            {{--<th></th>--}}
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('admin_get_approved_loans')}}',

                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'amount', name: 'amount'}
                    ]
                });
            });
        </script>
        @endpush
    </div>
@stop

@section('footer')

@stop

