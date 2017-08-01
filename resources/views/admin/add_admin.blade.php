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
                    <div class="alert alert-success">
                        <p>{{ session('status') }}</p>
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
                <h3>Add New Administrator</h3>
                <br>

                <form class="form-horizontal" action="{{route('add_admin')}}" method="post">
                    {{csrf_field()}}

                    <label>Last Name</label>
                    <div>
                        <input class="form-control" name="lastname" type="text" required value="{{old('lastname')}}">
                    </div>
                    <br>

                    <label>First Name</label>
                    <div>
                        <input class="form-control" name="firstname" type="text" required value="{{old('lastname')}}">
                    </div>
                    <br>

                    <label>Email</label>
                    <div>
                        <input class="form-control" name="email" type="email" required value="{{old('email')}}">
                    </div>
                    <br>

                    <label>Password</label>
                    <div>
                        <input class="form-control" name="password" type="password" required>
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

            <div class="col-sm-2"></div>
        </div>
    </div>
@stop