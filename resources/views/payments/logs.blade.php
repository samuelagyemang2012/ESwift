@extends('master1')

@section('content')
    <div class="col-2">
        <center><h3 style="color:#3C8DBC">System Logs</h3><hr></center>
        <table class="table" id="mytable">
            <thead>
            <th>Done by</th>
            <th>Message</th>
            <th>Created At</th>
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('payments_log')}}',

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

