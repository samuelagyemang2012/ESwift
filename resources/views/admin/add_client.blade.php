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

    <div class="container">
        <div class="row">

            <div class="col-sm-3"></div>

            <div class="col-sm-6">
                <h3>Add Client</h3>
                <br>

                <form class="form-horizontal" action="{{route('add_client')}}" method="post"
                      enctype="multipart/form-data">
                    {{csrf_field()}}

                    <label>First Name</label>
                    <div>
                        <input class="form-control" name="first_name" type="text" required value="{{old('first_name')}}"
                               min="2">
                    </div>
                    <br>

                    <label>Last Name</label>
                    <div>
                        <input class="form-control" name="last_name" type="text" required value="{{old('last_name')}}"
                               min="2">
                    </div>
                    <br>

                    <label>Email</label>
                    <div>
                        <input class="form-control" name="email" type="email" required value="{{old('email')}}">
                    </div>
                    <br>

                    <label>Telephone</label>
                    <div>
                        <input class="form-control" name="telephone" type="tel" required value="{{old('telephone')}}"
                               min="10">
                    </div>
                    <br>

                    <label>Employer</label>
                    <div>
                        <input class="form-control" name="employer" type="text" required value="{{old('employer')}}"
                               min="2">
                    </div>
                    <br>

                    <label>Employer Location</label>
                    <div>
                        <input class="form-control" name="employer_location" type="text" required
                               value="{{old('employer_location')}}" min="2">
                    </div>
                    <br>

                    <label>Residential Address</label>
                    <div>
                        <input class="form-control" name="residential_address" type="text" required
                               value="{{old('residential_address')}}" min="2">
                    </div>
                    <br>

                    <label>Carthograph</label>
                    <div>
                        <input class="form-control" name="carthograph" type="file" required
                               value="{{old('carthograph')}}">
                    </div>
                    <br>

                    <label>Monthly Salary</label>
                    <div>
                        <input class="form-control" name="salary" type="number" required value="{{old('salary')}}"
                               min="1">
                    </div>
                    <br>

                    <label>Select a Package</label><br>
                    <span style="color: cornflowerblue"><b id="package"></b></span><br>
                    {{--<label>This package allows you to borrow a maximum of GHC 500</label>--}}
                    <div>
                        <select class="form-control" name="package" id="pkg" onchange="packages()" required>
                            <option></option>
                            @foreach($packages as $p)
                                <option id="{{$p->id}}" value="{{$p->pname}}" onselect="">{{$p->pname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>

                    <label>Mobile Money Account</label>
                    <div>
                        <select class="form-control" name="mobile_money_account">
                            <option value="MTN">MTN</option>
                            <option value="TIGO">TIGO</option>
                            <option value="AIRTEL">AIRTEL</option>
                            <option value="VODAFONE">VODAFONE</option>
                        </select>
                    </div>
                    <br>


                    <label>Password</label>
                    <div>
                        <input class="form-control" name="password" type="password" required min="6">
                    </div>
                    <br>

                    <label>Confirm Password</label>
                    <div>
                        <input class="form-control" name="confirm_password" type="password" required>
                    </div>
                    <br>

                    <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                </form>
            </div>

            <div class="col-sm-3"></div>
        </div>
    </div>
@stop