@extends('layout.app')
@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">Edit subscriber</div>
            </div>
            <add-edit-component :subscriber="{{ json_encode($subscriber) }}"></add-edit-component>
        </div>
    </div>
</div>
@endsection
