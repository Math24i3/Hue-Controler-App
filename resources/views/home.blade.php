@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="col-md-12">
            <div class="jumbotron">
                <h1 class="display-4">Hue Controller Interface</h1>
                <p class="lead">This basic interface gives you the full control of a hue setup</p>
                <hr class="my-4">
                <p>Please try out the controls below</p>
                <light-switch v-bind:light-switch-endpoint="' {{ $lightSwitchEndpoint }}'"></light-switch>
                <brightness-controller v-bind:light-switch-endpoint="' {{ $lightSwitchEndpoint }}'"></brightness-controller>
            </div>
        </div>
</div>
@endsection
