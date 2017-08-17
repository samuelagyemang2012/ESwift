@extends('master2')

@section('content')
    <div class="col-2">
        <table class="table" id="mytable">
            <thead>
            <th>Done by</th>
            <th>Message</th>
            <th>created_at</th>
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('transactions_log')}}',

                    columns: [
                        {data: 'by', name: 'by'},
                        {data: 'message', name: 'message'},
                        {data: 'created_at', name: 'created_at'}
                    ]
                });
            })
            ;
        </script>
        @endpush
    </div>
@stop

@section('footer')

@stop

