@php
    $extends = auth()->user() ? 'errors::minimal' : 'errors::minimal-guest';
@endphp
@extends($extends)

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
