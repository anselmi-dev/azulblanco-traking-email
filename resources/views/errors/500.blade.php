@php
    $extends = auth()->user() ? 'errors::minimal' : 'errors::minimal-guest';
@endphp
@extends($extends)

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))
