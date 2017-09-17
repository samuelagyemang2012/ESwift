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
        </div>
    </div>

    <div class="container">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <form method="post" action="{{route('edit_rate')}}">
                {{csrf_field()}}
                <h3 style="color: #3C8DBC">{{$data->name}} (%)</h3>
                <hr>
                <div>
                    {{--<span>%</span>--}}
                    <input name="id" value="{{$data->id}}" hidden>
                    <input style="width: 100px" class="form-control" name="rate" type="number" value="{{$data->rate}}"
                           value="{{old('rate')}}" min="0" max="100" required>
                </div>
                <br>
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <div class="col-sm-4"></div>
    </div>
    <br>
@endsection