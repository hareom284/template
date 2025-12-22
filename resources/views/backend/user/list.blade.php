@extends('template.layout')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mt-4 text-center text-gray-800">Users List</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Users</h6>

            {{-- Add User button only for users with permission --}}
            @can('user_create')
                <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="text-center">{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                @if($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No Role</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(isset($user->status) && $user->status === 'inactive')
                                    <span class="badge bg-secondary">Inactive</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @can('user_edit')
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                @endcan
                                @can('user_delete')
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
