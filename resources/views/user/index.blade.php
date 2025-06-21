@extends('layouts.master')

@section('title', 'Manajemen User')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a href="{{ route('user.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Tambah User
            </a>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->level == 1)
                                    Admin
                                @elseif ($user->level == 2)
                                    Kasir
                                @else
                                    Pelanggan
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-xs btn-info">Edit</a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin hapus user ini?')">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-xs btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
