@extends('master3')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4">
                @if (session('status'))
                    <div class="alert alert-success">
                        <p>{{ session('status') }}</p>
                    </div>
                @endif
            </div>

            <div class="col-sm-4"></div>
        </div>
    </div>

    <div class="col-2">
        <center><h2 style="color: #3D8DBB">Unread Notifications</h2></center>
        <hr>

        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>Account Name</th>
            <th>Message</th>
            <th>Date</th>
            <th>Actions</th>
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('get_unread')}}',

                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'telephone', name: 'telephone'},
                        {data: 'message', name: 'message'},
                        {data: 'created_at', name: 'created_at'},
                        {
                            data: '6', name: 'action', render: function (data, type, full, meta) {
//                            alert(full['mobile_money_account']);
//                            var  s = full['0'];
                            return '<div>' +
                                    '<a title="" class="btn btn-sm btn-primary" href="/eswift/mark/' + full['id'] + '">Mark as read' + '</a>' +
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

