@extends('layouts.app')
@section('content')
    <!-- row -->
    <div class="row justify-content-center">
        <div class="col-md-6 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="col-xl-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">
                                <a href="{{ route('album.create') }}" class="btn btn-success btn-sm" role="button"
                                    aria-pressed="true">Add Album</a><br><br>
                                @if( $albums->count() > 0)
                                <div class="table-responsive">
                                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                        data-page-length="50" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Added User</th>
                                                <th>Pictures</th>
                                                <th>process</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($albums as $album)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $album->name }}</td>
                                                    <td>{{ $album->user->name }}</td>
                                                    <td><a href="{{ url('album') }}/{{ $album->id }}">Pictures</a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('album.edit', $album->id) }}"
                                                            class="btn btn-info btn-sm" role="button" aria-pressed="true"><i
                                                                class="fa fa-edit"></i></a>
                                                        <a class="modal-effect btn btn-sm btn-danger delete-modal"
                                                            data-effect="effect-scale" data-id="{{ $album->id }}"
                                                            data-toggle="modal" href="#modaldemo9" title="delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                    </table>
                                    <!-- delete -->
                                    <div class="modal" id="modaldemo9">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Delete</h6><button aria-label="Close"
                                                        class="close" data-dismiss="modal" type="button"><span
                                                            aria-hidden="true">&times;</span></button>
                                                </div>
                                                <form action="album/destroy" method="post">
                                                    {{ method_field('delete') }}
                                                    {{ csrf_field() }}
                                                    <div class="modal-body">
                                                        <p>Are you sure about deleting if you want to move pictures to
                                                            another album enter the album name</p><br>
                                                        <input type="hidden" name="id" id="id" value="">
                                                        <input class="form-control" name="album_name" id="album_name"
                                                            type="text">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">close</button>
                                                        <button type="submit" class="btn btn-danger">delete</button>
                                                    </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @else
                                    <p>There Are No Existing Albums </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $(".delete-modal").click(function() {
                $('#modaldemo9 .modal-body #id').val($(this).data('id'));
                $('#modaldemo9').modal('show');
            });
        });
    </script>
@endsection
