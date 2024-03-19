@php
    $extends = auth()->user() ? 'errors::minimal' : 'errors::minimal-guest';
@endphp
@extends($extends)

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
