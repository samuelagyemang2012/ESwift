@extends('master4')

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
                <h3>Edit Client Rate</h3>
                <br>

                <form class="form-horizontal" action="{{route('update_rate')}}" method="post">
                    {{csrf_field()}}

                    <input hidden name="id" value="{{$data->id}}">
                    <label>First Name</label>
                    <div>
                        <input readonly class="form-control" name="last_name" type="text" required
                               value="{{$data->first_name}}">
                    </div>
                    <br>

                    <label>Last Name</label>
                    <div>
                        <input readonly class="form-control" name="first_name" type="text" required
                               value="{{$data->last_name}}">
                    </div>
                    <br>

                    <label>Telephone</label>
                    <div>
                        <input readonly class="form-control" name="email" type="tel" required
                               value="{{$data->telephone}}">
                    </div>
                    <br>

                    <label>Interest Rate</label>
                    <div>
                        <input type="number" class="form-control" name="interest_rate" required max="100" min="1" value="{{$data->interest_rate}}">
                    </div>
                    <br>

                    <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                </form>
            </div>

            <div class="col-sm-3"></div>
        </div>
    </div>
@stop