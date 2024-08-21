@extends('errors.error')

@section('title', 'Service Unavailable')
@section('code', 503)
@section('message', $exception->getMessage() ?: 'Under maintenance. Please check back soon.')
