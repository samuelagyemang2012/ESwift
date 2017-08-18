@extends('master3')

@section('content')
    <div class="col-2">
        <table class="table" id="mytable">
            <thead>
            <th>Done By</th>
            <th>Message</th>
            <th>Date</th>
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    "order": [['created_at', "desc"]],
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('show_admin_logs')}}',

                    columns: [
                        {data: 'by', name: 'by'},
                        {data: 'message', name: 'message'},
                        {data: 'created_at', name: 'created_at'}
                    ]

                });


            });
        </script>
        @endpush
    </div>
@stop

@section('footer')

@stop