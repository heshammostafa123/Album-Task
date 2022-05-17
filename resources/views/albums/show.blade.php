@extends('layouts.app')
@section('content')
    <!-- row -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-6">
            <div class="card card-statistics h-100">
                <div class="card">
                    <div class="card-body">
                           @if( $pictures->count() > 0)
                                <div class="row">
                                    @foreach ($pictures as $picture)
                                    <div class="col-md-4">
                                        <div class="card">
                                            <img src="{{ asset('attachments').'/'.$album->id. '/' . $picture->image}}"  height="150px" width="150px" class="card-img-top mb-3">
                                            <div class="card-footer">
                                                <form action="{{ route('pictures.destroy','test')}}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="album_id" value="{{$album->id}}">
                                                        <input type="hidden" name="picture_name" value="{{$picture->image}}">
                                                        <input type="hidden" name="id" value="{{$picture->id}}">
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p> No images for this Album</p>
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
