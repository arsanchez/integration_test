@extends('layout.app')
@section('content')
<div class="container">
    <div class="row">
        @if ($valid_key)
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">Emails list search</div>
                <search-component ></search-component>
            </div>
        </div>
        @else
        <init-component ></init-component>
        @endif
    </div>
</div>
@endsection