@extends('master3')

@section('dashboard')
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$processed}}</h3>

                <p>Processed Loans</p>
            </div>
            <div class="icon">
                {{--<i class="ion ion-bag"></i>--}}
            </div>
            {{--<a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$amount_given}}<sup style="font-size: 20px"></sup></h3>

                <p>Total Amount Given</p>
            </div>
            <div class="icon">
                {{--<i class="ion ion-stats-bars"></i>--}}
            </div>
            {{--<a href="#" class="small-box-footer"> <i clas</a>--}}
        </div>
    </div>

    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$total_returns}}<sup style="font-size: 20px"></sup></h3>

                <p>Total Returns Expected</p>
            </div>
            <div class="icon">
                {{--<i class="ion ion-stats-bars"></i>--}}
            </div>
            {{--<a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$total_pending}}<sup style="font-size: 20px"></sup></h3>

                <p>Pending Loans</p>
            </div>
            <div class="icon">
                {{--<i class="ion ion-stats-bars"></i>--}}
            </div>
            {{--<a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$total_approved}}<sup style="font-size: 20px"></sup></h3>

                <p>Approved Loans</p>
            </div>
            <div class="icon">
                {{--<i class="ion ion-stats-bars"></i>--}}
            </div>
            {{--<a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$total_refused}}<sup style="font-size: 20px"></sup></h3>

                <p>Rejected Loans</p>
            </div>
            <div class="icon">
                {{--<i class="ion ion-stats-bars"></i>--}}
            </div>
            {{--<a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

@stop