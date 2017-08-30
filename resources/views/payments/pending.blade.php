@extends('master1')

@section('content')

    <div class="col-2">
        <table class="table" id="mytable">
            <thead>
            {{--<th>ID</th>--}}
            <th>ID</th>
            <th>Telephone Number</th>
            <th>Amount to Transfer</th>
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
                    ajax: '{{route('pending_transfers')}}',
//
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'telephone', name: 'telephone'},
                        {data: 'amount_to_transfer', name: 'amount_to_transfer'},
                        {
                            data: '6', name: 'action', render: function (data, type, full, meta) {
                            console.log(full);
//                            var  s = full['0'];
                            return '<div class="btn-group">' +
                                    '<a title="approve" class="btn btn-sm btn-primary" href="/eswift/payments/make-payment/' + full['id'] + '/' + full['amount_to_transfer'] + '/' + full['user_id'] + '/'+ full['telephone']+'/'+ full['loan_id'] +  '">Details' +
                                    '</a>' +
                                    '</div>';
                        }
                        }
                    ]
                });
            });
        </script>
        @endpush
    </div>
@stop

@section('footer')

@stop

