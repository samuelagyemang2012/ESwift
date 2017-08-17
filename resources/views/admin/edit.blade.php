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

            <div class="col-sm-2"></div>

            <div class="col-sm-8">
                <h3>Edit Client</h3>
                <br>

                <form class="form-horizontal" action="{{route('edit_client',['id'=>$data->id])}}" method="post"
                      enctype="multipart/form-data">
                    {{csrf_field()}}

                    <label>First Name</label>
                    <div>
                        <input class="form-control" name="first_name" type="text" required value="{{$data->first_name}}"
                               value="{{old('first_name')}}"
                               min="2">
                    </div>
                    <br>

                    <label>Last Name</label>
                    <div>
                        <input class="form-control" name="last_name" type="text" required value="{{$data->last_name}}"
                               value="{{old('last_name')}}"
                               min="2">
                    </div>
                    <br>

                    <label>Email</label>
                    <div>
                        <input class="form-control" name="email" type="email" required value="{{$data->email}}"
                               value="{{old('email')}}">
                    </div>
                    <br>

                    <label>Telephone</label>
                    <div>
                        <input class="form-control" name="telephone" type="tel" required value="{{$data->telephone}}"
                               value="{{old('telephone')}}"
                               min="10">
                    </div>
                    <br>

                    <label>Employer</label>
                    <div>
                        <input class="form-control" name="employer" type="text" required value="{{$data->employer}}"
                               value="{{old('employer')}}"
                               min="2">
                    </div>
                    <br>

                    <label>Employer Location</label>
                    <div>
                        <input class="form-control" name="employer_location" type="text" required
                               value="{{$data->employer_location}}" value="{{old('employer_location')}}" min="2">
                    </div>
                    <br>

                    <label>Residential Address</label>
                    <div>
                        <input class="form-control" name="residential_address" type="text" required
                               value="{{$data->residential_address}}" value="{{old('residential_address')}}" min="2">
                    </div>
                    <br>

                    <label>Carthograph</label>
                    <div>
                        <input type="file" class="form-control" name="carthograph"
                               value="{{old('carthograph')}}">
                    </div>
                    <br>

                    <label>Monthly Salary</label>
                    <div>
                        <input class="form-control" name="salary" type="number" required
                               value="{{$data->monthly_salary}}"
                               value="{{old('salary')}}"
                               min="1">
                    </div>
                    <br>

                    <label>Mobile Money Account</label>
                    <div>
                        <input readonly class="form-control" name="mobile_money_account"
                               value="{{$data->mobile_money_account}}"
                               value="{{old('mobile_money_account')}}" id="mma">
                    </div>
                    <br>
                    <div>
                        <select class="form-control" name="mobile_money_account" id="s_mma" onchange="helper()">
                            <option value="MTN">MTN</option>
                            <option value="TIGO">TIGO</option>
                            <option value="AIRTEL">AIRTEL</option>
                            <option value="VODAFONE">VODAFONE</option>
                        </select>
                    </div>
                    <br>

                    <label>Package</label>
                    <div>
                        <input readonly class="form-control" name="package"
                               value="{{$data->package}}"
                               value="{{old('package')}}" id="pk">
                    </div>
                    <br>
                    <div>
                        <select class="form-control" name="packages" id="s_pkg" onchange="packages_helper()">

                            @foreach($packages as $p)
                                <option value="{{$p->pname}}">{{$p->pname}}</option>
                            @endforeach
                            {{--<option value="MTN">MTN</option>--}}
                            {{--<option value="TIGO">TIGO</option>--}}
                            {{--<option value="AIRTEL">AIRTEL</option>--}}
                            {{--<option value="VODAFONE">VODAFONE</option>--}}
                        </select>
                    </div>
                    <br>

                    {{--<label>Password</label>--}}
                    {{--<div>--}}
                    {{--<input class="form-control" name="password" type="password" required min="6">--}}
                    {{--</div>--}}
                    {{--<br>--}}

                    {{--<label>Confirm Password</label>--}}
                    {{--<div>--}}
                    {{--<input class="form-control" name="confirm_password" type="password" required>--}}
                    {{--</div>--}}
                    {{--<br>--}}

                    <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                </form>
            </div>

            <div class="col-sm-2"></div>
        </div>
    </div>
@stop