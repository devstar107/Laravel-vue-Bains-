@extends('layouts.app')

@section('content')
    <job-app csrf_token="{{ csrf_token() }}" userdata="{{ $user }}"/>
    
@endsection

