@extends('master3')

{{----}}
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
            <center><h3 style="color: #3C8DBC">Confirm Payment</h3>
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

    <form class="form-horizontal" action="{{route('confirm_payment')}}" method="post"
          enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="container">
            <div class="row">

                <div class="col-sm-3"></div>

                <div class="col-sm-5">

                    <input hidden name="loan_id" value="{{$loan_id}}">
                    <input hidden name="debt_id" value="{{$debt_id}}">

                    <label>Account Name</label>
                    <div>
                        <input class="form-control" name="telephone" type="text" required readonly
                               value="{{$telephone}}"
                               min="2">
                    </div>
                    <br>

                    <label>Amount Paid</label>
                    <div>
                        <input class="form-control" name="amount_paid" type="number" required
                               value="" value="{{old('amount_paid')}}" min="0.5">
                    </div>
                    <br>

                    <label>Transaction ID</label>
                    <div>
                        <input class="form-control" name="transaction_id" type="text" required
                               value="" value="{{old('transaction_id')}}">
                    </div>
                    <br>

                    <label>Purpose</label>
                    <div>
                        <textarea type="text" class="form-control" name="purpose"
                                  value="{{old('purpose')}}"></textarea>
                    </div>
                    <br>

                    <label>Recorded By</label>
                    <div>
                        <input type="text" class="form-control" name="recorded_by" readonly
                               value="{{$by}}">
                    </div>
                    <br>


                    <button class="btn btn-primary btn-lg" type="submit">Confirm Payment</button>
                </div>

                <div class="col-sm-2"></div>

            </div>
        </div>
    </form>


@endsection