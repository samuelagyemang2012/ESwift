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

    <div class="container">
        <a href="{{route('show_add_package')}}" class="btn btn-primary">Add Package</a>
    </div>

    <br>

    {{--<div class="container">--}}
    <div class="col-2">
        <table class="table" id="mytable">
            <thead>
            <th>ID</th>
            <th>Package</th>
            <th>Description</th>
            <th>Maximum Amount (GHS)</th>
            <th></th>
            {{--<th></th>--}}
            {{--<th></th>--}}
            </thead>
        </table>

        @push('scripts')
        <script>
            $(function () {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{route('packages')}}',

                    columns: [
                        {data: '0', name: '0'},
                        {data: '1', name: '1'},
                        {data: '2', name: '2'},
                        {data: '3', name: '3'},
//                        {data: '6', name: 'maximum'}
                        {
                            data: '6', name: 'action', render: function (data, type, full, meta) {
                            console.log(full);
//                            var  s = full['0'];
                            return '<div class="btn-group"><a title="Edit User" class="btn btn-sm btn-primary" href="/eswift/edit/package/' + full['0'] + '"><i class="fa fa-pencil"></i></a><a class="btn btn-sm btn-danger"href="/delete_package/' + full['0'] + '"><i class="fa fa-trash"></i></a></div>';
                        }
                        }
                    ]
                });
            })
            ;
        </script>
        @endpush
    </div>
    {{--</div>--}}
@stop

@section('footer')

@stop