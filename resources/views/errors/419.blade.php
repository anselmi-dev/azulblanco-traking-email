@php
    $extends = auth()->user() ? 'errors::minimal' : 'errors::minimal-guest';
@endphp
@extends($extends)

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))
