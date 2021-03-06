@extends('master3')

@section('content')

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

    <div class="container">
        <a href="{{route('show_add_payment')}}" class="btn btn-primary">Add Payments Personnel</a>
        <a href="{{route('payments_excel')}}" class="btn btn-primary">Export as xls</a>
    </div>
    <br>

    <div class="col-2">

        <center><h2 style="color: #3D8DBB">Payments Personnel</h2></center>
        <hr>
        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Telephone</th>
            <th>Email</th>
            <th>Actions</th>
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('payments_personnel')}}',

                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'telephone', name: 'telephone'},
                        {data: 'email', name: 'email'},
                        {
                            data: '6', name: 'action', render: function (data, type, full, meta) {

                            return '<div class="btn-group"><a class="btn btn-sm btn-primary" href="edit/payments/' + full['id'] + '"><i class="fa fa-pencil"></i></a><a class="btn btn-sm btn-danger"href="delete_payments/' + full['id'] + '"><i class="fa fa-trash"></i></a></div>';

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

