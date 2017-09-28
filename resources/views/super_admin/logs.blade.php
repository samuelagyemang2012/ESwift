@extends('master4')

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
                    ajax: '{{route('superadmin_logs')}}',

//                    "order": [['created_at', "desc"]],

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