@extends('template.layout')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header text-center py-3">
                <h4 class="m-0 font-weight-bold text-primary">Create User</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="mb-3 row">
                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="userName" class="form-control @error('userName') is-invalid @enderror" id="name" placeholder="Eg: John Doe">
                            
                            @error('userName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                             @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="userEmail" class="form-control @error('userEmail') is-invalid @enderror" id="email" placeholder="example@gmail.com">
                        </div>

                        @error('userEmail')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="userPassword" class="form-control @error('userPassword') is-invalid @enderror" id="password" placeholder="Enter password">
                        
                            @error('userPassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        
                        </div>
                    </div>

                    <!--Role-->
                    <div class="mb-3">
                        <label for="roles" class="form-label">Roles *</label>
                        <div class="mb-2">
                            <button type="button" id="select-all" class="btn btn-sm btn-primary">Select All</button>
                            <button type="button" id="deselect-all" class="btn btn-sm btn-secondary">Deselect All</button>
                        </div>

                        <select name="roles[]" id="roles" class="form-select" multiple>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mb-3 row">
                        <label for="status" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select name="status" id="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

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
