@extends('master1')

@section('dashboard')

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$total_transfers}}</h3>

                <p>Total Transfers</p>
            </div>
            <div class="icon">
                <i class="ion ion-arrow-graph-up-left"></i>
            </div>
            <a class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{$total_amount}}</h3>

                <p>Total Amount Transferred</p>
            </div>
            <div class="icon">
                <i class="ion ion-cash"></i>
            </div>
            <a class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$total_transfers_today}}</h3>

                <p>Total Transfers Today</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>12</h3>

                <p>Total Amount Transferred Today</p>
            </div>
            <div class="icon">
                <i class="ion ion-card"></i>
            </div>
            <a class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

@stop