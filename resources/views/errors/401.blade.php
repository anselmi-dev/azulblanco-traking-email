@php
    $extends = auth()->user() ? 'errors::minimal' : 'errors::minimal-guest';
@endphp
@extends($extends)

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized'))
