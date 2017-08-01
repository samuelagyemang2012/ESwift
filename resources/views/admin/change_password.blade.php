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
            <div class="col-sm-4"></div>

            <div class="col-sm-4">
                @if (session('status'))
                    <div class="alert alert-danger">
                        <p>{{ session('status') }}</p>
                    </div>
                @endif
            </div>

            <div class="col-sm-4"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4">
                @if (session('status1'))
                    <div class="alert alert-success">
                        <p>{{ session('status1') }}</p>
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
                <h3>Change Password</h3>
                <br>

                <form class="form-horizontal" action="{{route('change_password')}}" method="post">
                    {{csrf_field()}}

                    <label>Email</label>
                    <div>
                        <input class="form-control" name="email" type="text" readonly value="{{$email}}"
                               value="{{old('email')}}">
                    </div>
                    <br>

                    <label>Old Password</label>
                    <div>
                        <input class="form-control" name="old_password" type="password" required>
                    </div>
                    <br>

                    <label>New Password</label>
                    <div>
                        <input class="form-control" name="new_password" type="password" required>
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
        </div>
    </div>

@stop