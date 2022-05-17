@extends('layouts.app')
@section('content')
    <!-- row -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-6">
            <div class="card card-statistics h-100">
                <div class="card">
                    <div class="card-body">
<!-- Example of a form that Dropzone can take over -->
<form action="/target" class="dropzone"></form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
