@extends('master1')

@section('content')

    <div class="col-2">
        <center><h3 style="color:#3C8DBC">Completed Transfers</h3><hr></center>
        <table class="table" id="mytable">
            <thead>
            {{--<th>ID</th>--}}
            <th>ID</th>
            <th>Transaction ID</th>
            <th>Transferred By</th>
            {{--<th>Telephone Number</th>--}}
            <th>Amount Transferred</th>
            <th></th>
            </thead>
        </table>
        {{----}}
        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('completed_transfers')}}',
//
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'transaction_id', name: 'transaction_id'},
                        {data: 'transferred_by', name: 'transferred_by'},
//                        {data: 'telephone', name: 'telephone'},
                        {data: 'amount_to_transfer', name: 'amount_to_transfer'},
//                        {data: '6', name: 'action',}
                    ]
                });
            });
        </script>
        @endpush
    </div>
@stop

@section('footer')

@stop

