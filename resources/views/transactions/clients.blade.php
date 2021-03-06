@extends('master2')

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
        <a href="{{route('t_show_add_client')}}" class="btn btn-primary">Add Client</a>
    </div>
    <br>

    <div class="col-2">
        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>

            <th>Telephone</th>
            <th>Residential Address</th>
            <th>Salary</th>

            {{--<th>Mobile Money Account</th>--}}
            <th></th>

            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('trans_clients')}}',

                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},

                        {data: 'telephone', name: 'telephone'},
                        {data: 'residential_address', name: 'residential_address'},
                        {data: 'monthly_salary', name: 'monthly_salary'},
//                        {data: 'mobile_money_account', name: 'mobile_money_account'},
                        {
                            data: '6', name: 'action', render: function (data, type, full, meta) {
                            console.log(full);
//                            var  s = full['0'];
                            return '<div class="btn-group"><a class="btn btn-sm btn-success" href="client/details/' + full['id'] + '"><i class="fa fa-question"></i></a><a class="btn btn-sm btn-primary" href="edit/client/' + full['id'] + '"><i class="fa fa-pencil"></i></a><a class="btn btn-sm btn-danger" onclick="del_client(' + full['id'] + ')"><i class="fa fa-trash"></i></a></div>';
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