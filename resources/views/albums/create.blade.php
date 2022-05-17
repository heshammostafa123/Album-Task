@extends('layouts.app')
@section('content')
    <!-- row -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-6">
            <div class="card card-statistics h-100">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('album.store') }}" method="post" enctype="multipart/form-data"
                            autocomplete="off">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">Album Name</label>
                                    <input type="text" class="form-control" id="inputName" name="album_name"
                                        title="Album Name" required>
                                    @error('album_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-12 col-md-12">
                                <label for="inputName" class="control-label">Pictures</label>
                                <input type="file" name="pic[]" class="dropify form-control"
                                     data-height="70" multiple />
                                @error('pic')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <p class="text-danger"> Attachment Format* => jpeg , jpg , png </p>
                            </div><br>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">save Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
