@extends('errors.error')

@section('title', 'Too Many Requests')
@section('code', 429)
@section('message', sprintf('You have reached your request limit, please retry in %s seconds.', ($exception->getHeaders()['Retry-After'] ?? 'a few')))
