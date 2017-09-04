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
                <h3>Edit Packages</h3>
                <br>

                <form class="form-horizontal" action="{{route('edit_package')}}" method="post">
                    {{csrf_field()}}

                    <input name="id" type="text" value="{{$id}}" hidden>

                    <label>Name</label>
                    <div>
                        <input style="" class="form-control" name="name" type="text" required value="{{$data->pname}}"
                               value="{{old('name')}}">
                    </div>
                    <br>

                    <label>Description</label>
                    <div>
                        <textarea rows="4" class="form-control" name="description" type="text"
                                  value="{{old('desc')}}">{{$data->description}}</textarea>
                    </div>
                    <br>

                    <label>Maximum Amount</label>
                    <div>
                        <input class="form-control" name="amount" type="number" required value="{{$data->maximum}}"
                               value="{{old('amount')}}"
                               min="100">
                    </div>
                    <br>

                    <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                </form>
            </div>

            <div class="col-sm-2"></div>
        </div>
    </div>
@stop