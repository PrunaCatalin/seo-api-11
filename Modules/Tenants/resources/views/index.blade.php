@extends('tenants::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('tenants.name') !!}</p>
@endsection
