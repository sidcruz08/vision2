@extends('layouts.app')
@section('content')
    <h1>Edit Visit</h1>
    <form method="POST" action="{{ route('visits.update', $visit) }}">
        @csrf
        @method('PUT')
        @include('visits.form')
    </form>
@endsection