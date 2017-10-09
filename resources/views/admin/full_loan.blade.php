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

    <div class="col-2">
        <div class="container">
            <a href="{{route('elapsed_excel')}}" class="btn btn-primary">Export as xls</a>
        </div>

        <center><h2 style="color: #3D8DBB">Elapsed Loans</h2></center>
        <hr>

        <table class="table" id="mytable">
            <thead>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Telephone</th>
            <th>Debt (GHC)</th>
            <th>Full Loan Date</th>
            {{--<th></th>--}}
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('elapsed_loans')}}',

                    columns: [
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'telephone', name: 'telephone'},
                        {data: 'total_debt', name: 'total_debt'},
                        {data: 'full_loan_date', name: 'full_loan_date'}
//                        {
//                            data: '6', name: 'action', render: function (data, type, full, meta) {
////                            console.log(full);
////                            var  s = full['0'];
//                            return '<div><a class="btn btn-sm btn-primary" href="/eswift/account_deductions/' + full['user_id'] + '">Go To Account</a></div>';
//                        }
//                        }
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