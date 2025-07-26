{{-- edit.blade.php --}}
@extends('layouts.app')
@section('content')
<h2>Edit Treatment</h2>
<form method="POST" action="{{ route('treatments.update', $treatment->id) }}">
    @method('PUT')
    @include('treatments.form')
</form>
@endsection
