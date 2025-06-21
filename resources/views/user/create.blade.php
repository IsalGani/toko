@extends('layouts.master')
@section('title', 'Tambah User')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        @include('user.partials.form', ['submit' => 'Simpan'])
    </form>
@endsection
