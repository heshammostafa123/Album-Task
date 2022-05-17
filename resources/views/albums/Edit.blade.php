@extends('layouts.app')
@section('content')
    <!-- row -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-6">
            <div class="card card-statistics h-100">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('album.update', $album->id) }}" method="post" enctype="multipart/form-data"
                            autocomplete="off">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">Album Name</label>
                                    <input type="text" class="form-control" id="inputName" name="album_name"
                                        title="Album Name" value="{{ $album->name }}">
                                    <input type="hidden" name="id" value="{{ $album->id }}">
                                    @error('album_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                @foreach ($album->pictures as $picture)
                                    <div class="col-sm-3">

                                        <img src="{{ asset('attachments') . '/' . $album->id . '/' . $picture->image }}"
                                            height="150px" width="150px" class="mb-3">
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="inputName" class="control-label">Pictures</label>
                                <input type="file" name="pic[]" class="dropify form-control" data-height="70" multiple />
                                @error('pic')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <p class="text-danger"> Attachment Format* => jpeg , jpg , png </p>
                            </div><br>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
