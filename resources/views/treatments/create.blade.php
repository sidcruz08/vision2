{{-- create.blade.php --}}
@extends('layouts.app')
@section('content')
<h2>Create Treatment</h2>
<form method="POST" action="{{ route('treatments.store') }}">
    @include('treatments.form')
</form>
@endsection
