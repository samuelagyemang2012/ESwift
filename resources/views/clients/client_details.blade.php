@extends('master3')

@section('content')
    <div class="container">
        <div class="col-sm-2"></div>

        <div class="col-sm-8">
            <div>
                <center><h3 style="color: #3C8DBC">Eswift Account Details</h3></center>
            </div>

            <table class="table table-bordered">
                <thead>
                <th> Account Name</th>
                <td style="color: #3c8dbc">{{$edata->name}}</td>
                </thead>

                <thead>
                <th> Account Number</th>
                <td style="color: #3c8dbc">{{$edata->eaccount_number}}</td>
                </thead>

                <thead>
                <th> Balance</th>
                <td style="color: #3c8dbc">{{$edata->balance}}</td>
                </thead>
            </table>
            <br>

            <div>
                <center><h3 style="color: #3C8DBC">Mobile Set-Up Fee Account</h3></center>
            </div>

            <table class="table table-bordered">
                <thead>
                <th> Account Name</th>
                <td style="color: #3c8dbc">{{$mdata->name}}</td>
                </thead>

                <thead>
                <th> Account Number</th>
                <td style="color: #3c8dbc">{{$mdata->maccount_number}}</td>
                </thead>

                <thead>
                <th> Balance</th>
                <td style="color: #3c8dbc">{{$mdata->balance}}</td>
                </thead>
            </table>
            <br>

            <div>
                <center><h3 style="color: #3C8DBC">Client Details</h3></center>
            </div>
            <br>

            <table class="table table-bordered">

                <thead>
                <th>Multi Money Savings Account Number</th>
                <td style="color: #3c8dbc">{{$data->multimoney_account_number}}</td>
                </thead>

                <thead>
                <th>First Name</th>
                <td style="color: #3c8dbc">{{$data->first_name}}</td>
                </thead>

                <thead>
                <th>Last Name</th>
                <td style="color: #3c8dbc">{{$data->last_name}}</td>
                </thead>

                <thead>
                <th>Email</th>
                <td style="color: #3c8dbc">{{$data->email}}</td>
                </thead>

                <thead>
                <th>Telephone</th>
                <td style="color: #3c8dbc">{{$data->telephone}}</td>
                </thead>

                <thead>
                <th>Residential Address</th>
                <td style="color: #3c8dbc">{{$data->residential_address}}</td>
                </thead>

                <thead>
                <th>Employer</th>
                <td style="color: #3c8dbc">{{$data->employer}}</td>
                </thead>

                <thead>
                <th>Employer Location</th>
                <td style="color: #3c8dbc">{{$data->employer_location}}</td>
                </thead>

                <thead>
                <th>Salary</th>
                <td style="color: #3c8dbc">GHC {{$data->monthly_salary}}</td>
                </thead>

                <thead>
                <th>Mobile Money Account</th>
                <td style="color: #3c8dbc">{{$data->mobile_money_account}}</td>
                </thead>

                <thead>
                <th>Package</th>
                <td style="color: #3c8dbc">{{$data->package}}</td>
                </thead>

            </table>
            <hr>
            <div>
                <h3>Carthograph </h3>
                <hr>
                <img src="/uploads/{{$data->carthograph}}" width="100%">
            </div>
            <br>
        </div>

        <div class="col-sm-2"></div>

    </div>
@stop
