@php
    $extends = auth()->user() ? 'errors::minimal' : 'errors::minimal-guest';
@endphp
@extends($extends)

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable'))
