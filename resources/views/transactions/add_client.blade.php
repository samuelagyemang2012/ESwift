@extends('master2')

@section('content')

    <div class="container">
        <div class="row">
            {{--dsdfdssd--}}
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

                @if (session('status1'))
                    <div class="alert alert-danger">
                        <p>{{ session('status1') }}</p>
                    </div>
                @endif

            </div>

            <div class="col-sm-4"></div>

        </div>
    </div>

    <div class="container">
        <div class="col-sm-4"></div>

        <div class="col-sm-4">
            <center><h3 style="color: #3C8DBC">Add a Client</h3>
                <hr>
            </center>

            {{--<hr>--}}
        </div>

        <div class="col-sm-4"></div>
    </div>

    <div class="container">
        {{--Modal--}}
        <div id="modal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body" id="modalbody">
                        <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <form class="form-horizontal" action="{{route('t_add_client')}}" method="post"
          enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="container">
            <div class="row">

                {{--<div class="col-sm-1"></div>--}}

                <div class="col-sm-2">
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

                    <label>Telephone</label><br>
                    <span style="color: cornflowerblue"><b id="telplus"></b></span>
                    <div>
                        <input id="tel" class="form-control" name="telephone" type="tel" onblur="process_tel()" required
                               value="{{old('telephone')}}"
                               min="12">
                    </div>
                    <br>

                    <label>Mobile Money Account</label>
                    <div>
                        <input class="form-control" name="mobile_money_account" id="mobile_money_account" readonly
                               value="{{old('mobile_money_account')}}">
                    </div>
                    <br>

                </div>

                <div class="col-sm-2">

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

                </div>

                <div class="col-sm-3">

                    <label>Multi-Money Savings Acount Number</label><br>
                    <div>
                        <input class="form-control" name="multimoney_account_number" value="{{old('multimoney_account_number')}}" type="text" required>
                    </div>
                    <br>

                    {{--<label>20% of Multi-Money Savings Account</label><br>--}}
                    {{--<div>--}}
                    {{--<input class="form-control" name="percentage" value="{{old('percentage')}}" type="text" required>--}}
                    {{--</div>--}}
                    {{--<br>--}}

                    <label>Select a Package</label><br>
                    <span style="color: cornflowerblue"><b id="package"></b></span>

                    <div>
                        <select class="form-control" name="package" id="pkg" onchange="get_balance()" required>
                            <option></option>
                            @foreach($packages as $p)
                                <option id="{{$p->id}}" value="{{$p->pname}}"
                                        onselect="packages(this)">{{$p->pname}}&nbsp;(GHC {{$p->maximum}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <br>

                    <label>Eswift Password</label>
                    <div>
                        <input class="form-control" name="password" type="password" required min="6">
                    </div>
                    <br>

                    <label>Confirm Eswift Password</label>
                    <div>
                        <input class="form-control" name="confirm_password" type="password" required>
                    </div>
                    <br>

                </div>

                <div class="col-sm-3">
                    <label>Picture</label>
                    <div>
                        <input class="form-control" name="picture" type="file" required
                               value="{{old('picture')}}">
                    </div>
                    <br>

                    <label>Monthly Salary</label>
                    <div>
                        <input class="form-control" name="salary" type="number" required value="{{old('salary')}}"
                               min="1">
                    </div>
                    <br>

                    <label>Secret Question</label><br>
                    <div>
                        <select class="form-control" name="secret_question" required>
                            <option></option>
                            <option value="What time of the day were you born">What time of the day were you born?
                            </option>
                            <option value="What primary school did you attend">What primary school did you attend?
                            </option>
                            <option value="In what town or city did you meet your spouse">In what town or city did you
                                meet your spouse?
                            </option>
                            <option value="What is your mother's maiden name">What is your mother's maiden name?
                            </option>
                            <option value="What was the street name you lived on as a child">What was the street name
                                you lived on as a child?
                            </option>

                        </select>
                    </div>
                    <br>

                    <label>Secret Answer</label><br>
                    <div>
                        <input class="form-control" name="secret_answer" type="text" required>
                    </div>
                    <br>
                    <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
    {{--</div>--}}
@stop