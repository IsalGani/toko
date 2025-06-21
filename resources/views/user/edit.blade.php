@extends('layouts.master')
@section('title', 'Edit User')

@section('content')
    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('put')
        @include('user.partials.form', ['submit' => 'Update'])
    </form>
@endsection
