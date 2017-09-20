@extends('master3')

@section('content')
    <div class="col-2">
        <center><h2 style="color: #3D8DBB">Read Notifications</h2></center>
        <hr>

        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>Account Name</th>
            <th>Message</th>
            <th>Date</th>
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('get_read')}}',

                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'telephone', name: 'telephone'},
                        {data: 'message', name: 'message'},
                        {data: 'updated_at', name: 'updated_at'}
                    ]
                });
            });
        </script>
        @endpush
    </div>
@stop

@section('footer')

@stop

