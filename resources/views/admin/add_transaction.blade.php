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

            <div class="col-sm-3"></div>

            <div class="col-sm-6">
                <h3>Add Transactions Personnel</h3>
                <br>

                <form class="form-horizontal" action="{{route('add_transaction')}}" method="post">
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

                    <label>Residential Address</label>
                    <div>
                        <input class="form-control" name="residential_address" type="text" required
                               value="{{old('residential_address')}}" min="2">
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