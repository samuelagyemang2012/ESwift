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
        <div class="col-sm-4"></div>

        <div class="col-sm-4">
            <center><h3 style="color: #3C8DBC">Edit a Client</h3>
                <hr>
            </center>

            {{--<hr>--}}
        </div>
        <div class="col-sm-4"></div>
    </div>

    <div class="container">
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

    <form class="form-horizontal" action="{{route('edit_client',['id'=>$data->id])}}" method="post"
          enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="container">
            <div class="row">

                <div class="col-sm-2">
                    {{----}}
                    {{----}}
                    {{--<label>Select a New Package</label><br>--}}
                    {{--<span style="color: cornflowerblue"><b id="package"></b></span>--}}
                    {{--<div>--}}
                    {{--<select class="form-control" name="packages" id="pkg" onchange="get_balance()">--}}
                    {{--<option></option>--}}
                    {{--@foreach($packages as $p)--}}
                    {{--<option value="{{$p->pname}}">{{$p->pname}}</option>--}}
                    {{--@endforeach--}}
                    {{--</select>--}}
                    {{--</div>--}}
                    {{--<br>--}}
                </div>

                <div class="col-sm-4">

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
                               value="{{old('mobile_money_account')}}" id="mobile_money_account">
                    </div>
                    <br>

                    <button class="btn btn-primary btn-lg" type="submit">Submit</button>

                    {{--<label>Telephone</label>--}}
                    {{--<div>--}}
                    {{--<input onblur="process_tel()" class="form-control" name="telephone" type="tel" required--}}
                    {{--value="{{$data->telephone}}"--}}
                    {{--value="{{old('telephone')}}"--}}
                    {{--min="10" id="tel">--}}
                    {{--</div>--}}
                    {{--<br>--}}

                </div>

                <div class="col-sm-4">

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

                    <label>Current Package</label>
                    <div>
                        <input readonly class="form-control" name="package"
                               value="{{$data->package}}"
                               value="{{old('package')}}" id="pk">
                    </div>
                    <br>


                </div>

                {{--<div class="col-sm-2">--}}


                {{--<label>Select a New Package</label><br>--}}
                {{--<span style="color: cornflowerblue"><b id="package"></b></span>--}}
                {{--<div>--}}
                {{--<select class="form-control" name="packages" id="pkg" onchange="get_balance()">--}}
                {{--<option></option>--}}
                {{--@foreach($packages as $p)--}}
                {{--<option value="{{$p->pname}}">{{$p->pname}}</option>--}}
                {{--@endforeach--}}
                {{--</select>--}}
                {{--</div>--}}
                {{--<br>--}}


                {{--</div>--}}

            </div>
        </div>
    </form>

@stop