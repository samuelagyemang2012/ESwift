@extends('master3')

@section('content')
    {{--<h1>dassadasd</h1>--}}
    <div class="container">
        {{----}}
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div>
                <center><h3 style="color: #3C8DBC">Debt Details</h3></center>
            </div>
            <br>

            <table class="table table-bordered">
                <thead>
                <th> Account Name</th>
                <td style="color: #3c8dbc">{{$data->telephone}}</td>
                </thead>

                <thead>
                <th> Firstname</th>
                <td style="color: #3c8dbc">{{$data->first_name}}</td>
                </thead>

                <thead>
                <th> Lastname</th>
                <td style="color: #3c8dbc">{{$data->last_name}}</td>
                </thead>

                <thead>
                <th> Amount Borrowed GHC</th>
                <td style="color: #3c8dbc">{{$data->amount_borrowed}}</td>
                </thead>

                <thead>
                <th>Amount Paid</th>
                <td style="color: #3c8dbc">{{$data->amount_paid}}</td>
                </thead>

                <thead>
                <th> Half Loan Due</th>
                <td style="color: #3c8dbc">{{$data->half_debt}}</td>
                </thead>

                <thead>
                <th> Half Loan Due Date</th>
                <td style="color: #3c8dbc">{{$half}}</td>
                </thead>
                {{----}}
                <thead>
                <th> Full Loan Due</th>
                <td style="color: #3c8dbc">{{$data->total_debt}}</td>
                </thead>
                {{----}}
                <thead>
                <th> Full Loan Due Date</th>
                <td style="color: #3c8dbc">{{$full}}</td>
                </thead>
            </table>
            <br>
        </div>
        {{----}}
        <div class="col-sm-3"></div>
    </div>
@endsection