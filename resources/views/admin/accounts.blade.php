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

    {{--<div class="container">--}}
    {{--<a href="{{route('show_add_client')}}" class="btn btn-primary">Add Client</a>--}}
    {{--</div>--}}
    <br>

    <div class="col-6">
        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Account Name</th>
            {{--<th>Eswift Account Balance</th>--}}
            {{--<th>Salary</th>--}}
            {{--<th>Regeistration Fee Account</th>--}}
            <th></th>
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('clients')}}',

                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'telephone', name: 'telephone'},
//                        {data: 'residential_address', name: 'residential_address'},
//                        {data: 'monthly_salary', name: 'monthly_salary'},
                        {
                            data: '6', name: 'action', render: function (data, type, full, meta) {
//                            console.log(full);
//                            var  s = full['0'];
                            return '<a class="btn btn-sm btn-primary" href="accounts/' + full['id'] + '">Details</a>';//<a class="btn btn-sm btn-primary" href="edit/client/' + full['id'] + '"><i class="fa fa-pencil"></i></a><a class="btn btn-sm btn-danger"href="delete_client/' + full['id'] + '/' + full['telephone'] + '"><i class="fa fa-trash"></i></a></div>';
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