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
        <center><h2 style="color: #3D8DBB">Elapsed Half Loans</h2></center>
        <hr>
        <table class="table" id="mytable">
            <thead>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Telephone</th>
            <th>Half Debt (GHC)</th>
            <th>Half Loan Date</th>
            <th></th>
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('half_loans_due')}}',

                    columns: [
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'telephone', name: 'telephone'},
                        {data: 'half_debt', name: 'half_debt'},
                        {data: 'half_loan_date', name: 'half_loan_date'},
                        {
                            data: '6', name: 'action', render: function (data, type, full, meta) {
//                            console.log(full);
//                            var  s = full['0'];
                            return '<div><a class="btn btn-sm btn-primary" href="/eswift/account_deductions/' + full['id'] +'/'+ full['user_id'] + '">Go To Account</a></div>';
                        }
                        }
                    ],

                    "order": [[4, "desc"]]
                });
            })
            ;
        </script>
        @endpush
    </div>
@stop

@section('footer')

@stop