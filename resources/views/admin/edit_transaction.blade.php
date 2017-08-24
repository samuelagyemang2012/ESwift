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
            <center><h3 style="color: #3C8DBC">Edit Payments Personnel</h3>
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

    <form class="form-horizontal" action="{{route('edit_transactions_personnel',['id'=>$data->id])}}" method="post"
          enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="container">
            <div class="row">

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

                    <label>Telephone</label>
                    <div>
                        <input onblur="process_tel()" class="form-control" name="telephone" type="tel" required
                               value="{{$data->telephone}}"
                               value="{{old('telephone')}}"
                               min="10" id="tel">
                    </div>
                    <br>
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

                    <div>
                        <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

@stop