@php
    $extends = auth()->user() ? 'errors::minimal' : 'errors::minimal-guest';
@endphp
@extends($extends)

@section('title', __('Payment Required'))
@section('code', '402')
@section('message', __('Payment Required'))
