@extends('master3')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4">
                @if(count($errors))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="col-sm-4"></div>

        </div>
    </div>

    <form method="post" action="{{route('update_account_hld',['id'=>$id])}}">
        {{csrf_field()}}
        <div class="container">
            <div class="col-sm-1"></div>

            <div class="col-sm-4">
                <div>
                    <center><h4 style="color: #3C8DBC">Eswift Account Details</h4>
                        <hr>
                    </center>
                </div>

                <div>

                    <input hidden value="{{$edata->id}}" name="debt_id">
                    <label> Account Name</label>
                    <input class="form-control" value="{{$edata->name}}" readonly><br>

                    <label> Account Number</label>
                    <input class="form-control" value="{{$edata->eaccount_number}}" readonly><br>

                    <label>Eswift Account Balance</label>
                    <input name="eswift_balance" class="form-control" value="{{$edata->balance}}" required><br>
                    <br>
                </div>
            </div>

            <div class="col-sm-2"></div>

            <div class="col-sm-4">
                <div>
                    <center><h4 style="color: #3C8DBC">Mobile Set-Up Fee Account</h4>
                        <hr>
                    </center>
                </div>

                <div>

                    <label> Account Name</label>
                    <input class="form-control" value="{{$mdata->name}}" readonly>
                    <br>

                    <label> Account Number</label>
                    <input class="form-control" value="{{$mdata->maccount_number}}" readonly><br>

                    <label> Mobile Set-Up Fee Account Balance</label>
                    <input name="mobile_registration_balance" class="form-control" value="{{$mdata->balance}}" required><br>
                    <br>
                </div>
            </div>

            <div class="col-sm-1"></div>

        </div>

        <div class="container">
            <div class="col-sm-1"></div>

            <div class="col-sm-4"></div>

            <div class="col-sm-2">
                <button class="btn btn-primary btn-lg" type="submit">Submit</button>
            </div>

            <div class="col-sm-4"></div>

            <div class="col-sm-1"></div>
        </div>

    </form>

@endsection