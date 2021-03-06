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
//
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('show_admin_logs')}}',

//                    "order": [['created_at', "desc"]],

                    columns: [
                        {data: 'by', name: 'by'},
                        {data: 'message', name: 'message'},
                        {data: 'created_at', name: 'created_at'}
                    ],

                    "order": [[2, "desc"]]

                });


            });
        </script>
        @endpush
    </div>
@stop

@section('footer')

@stop