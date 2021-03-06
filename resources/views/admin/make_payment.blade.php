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
                <h3>Make Payment</h3>
                <br>

                <form class="form-horizontal" action="{{route('admin_make_payment')}}" method="post">
                    {{csrf_field()}}

                    <div>
                        <label>Telephone Number</label>
                        <input class="form-control" readonly name="telephone" value="{{$telephone}}">
                        <br>
                    </div>

                    <div>
                        <label>Amount To Transfer</label>
                        <input hidden value="{{$id}}" name="id">
                        <input hidden value="{{$user_id}}" name="user_id">
                        <input hidden value="{{$loan_id}}" name="loan_id">

                        <input class="form-control" readonly name="amount_to_transfer" value="{{$amount}}">
                        {{--<br>--}}
                    </div>
                    <hr>

                    <div>
                        <label>Amount Transferred<b style="color: crimson"> *</b></label>
                        <input class="form-control" name="amount_transferred" required>
                    </div>
                    <br>

                    <div>
                        <label>Transaction ID<b style="color: crimson"> *</b></label>
                        <input class="form-control" name="transaction_id" required value="{{old('transaction_id')}}">
                    </div>
                    <br>

                    <div>
                        <label>Comments</label>
                        <textarea class="form-control" name="comments" value="{{old('comments')}}"></textarea>
                    </div>
                    <br>

                    <div>
                        <button class="btn btn-primary" type="submit">Make Payment</button>
                    </div>

                </form>

            </div>

            <div class="col-sm-3"></div>
        </div>
    </div>
@stop