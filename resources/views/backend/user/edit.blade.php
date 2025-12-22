@extends('template.layout')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header text-center py-3">
                <h3 class="m-0 font-weight-bold text-primary">Edit User</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input 
                                type="text" 
                                name="userName" 
                                class="form-control @error('userName') is-invalid @enderror" 
                                id="name" 
                                placeholder="Eg: John Doe" 
                                value="{{ old('userName', $user->name ?? '') }}"
                            >
                            @error('userName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input 
                                type="email" 
                                name="userEmail" 
                                class="form-control @error('userEmail') is-invalid @enderror" 
                                id="email"  
                                value="{{ old('userEmail', $user->email ?? '') }}"  
                                placeholder="example@gmail.com"
                            >
                            @error('userEmail')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    {{-- <div class="mb-3 row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input 
                                type="password" 
                                name="userPassword" 
                                class="form-control @error('userPassword') is-invalid @enderror" 
                                id="password" 
                                placeholder="Enter new password (leave blank to keep current)"
                            >
                            @error('userPassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}

                    {{-- Roles --}}
                    <div class="mb-3 row">
                        <label for="roles" class="col-sm-3 col-form-label">Roles</label>
                        <div class="col-sm-9">
                            <div class="d-flex mb-2">
                                <button type="button" id="select-all" class="btn btn-sm btn-primary me-2">Select All</button>
                                <button type="button" id="deselect-all" class="btn btn-sm btn-secondary">Deselect All</button>
                            </div>
                            <select 
                                name="roles[]" 
                                id="roles" 
                                class="form-select @error('roles') is-invalid @enderror" 
                                multiple
                            >
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ in_array($role->name, $userRoles ?? []) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('roles')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3 row">
                        <label for="status" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $user->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="text-end">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Back</a>
                        <button type="submit" class="btn btn-primary px-4">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all');
        const deselectAll = document.getElementById('deselect-all');
        const rolesSelect = document.getElementById('roles');

        if (selectAll) selectAll.addEventListener('click', () => {
            for (let i = 0; i < rolesSelect.options.length; i++) {
                rolesSelect.options[i].selected = true;
            }
        });

        if (deselectAll) deselectAll.addEventListener('click', () => {
            for (let i = 0; i < rolesSelect.options.length; i++) {
                rolesSelect.options[i].selected = false;
            }
        });
    });
</script>
@endpush
