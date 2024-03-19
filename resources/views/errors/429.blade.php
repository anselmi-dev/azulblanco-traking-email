@php
    $extends = auth()->user() ? 'errors::minimal' : 'errors::minimal-guest';
@endphp
@extends($extends)

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Too Many Requests'))
