@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">{{ __('Filters') }}</h6>
                        <form action="{{ route('users.index') }}" method="GET">
                            <div class="row">
                                <div class="form-group col">
                                    <label for="first_name">{{ ('First Name') }}</label>
                                    <input
                                            id="first_name"
                                            type="text"
                                            class="form-control @error('filter.first_name') is-invalid @enderror"
                                            name="filter[first_name]"
                                            value="{{ old('filter.first_name', request('filter.first_name')) }}"
                                    >

                                    @error('filter.first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col">
                                    <label for="first_name">{{ ('Last Name') }}</label>
                                    <input
                                            id="last_name"
                                            type="text"
                                            class="form-control @error('filter.last_name') is-invalid @enderror"
                                            name="filter[last_name]"
                                            value="{{ old('filter.last_name', request('filter.last_name')) }}"
                                    >

                                    @error('filter.last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col">
                                    <label for="first_name">{{ ('Email') }}</label>
                                    <input
                                            id="email"
                                            type="text"
                                            class="form-control @error('filter.email') is-invalid @enderror"
                                            name="filter[email]"
                                            value="{{ old('filter.email', request('filter.email')) }}"
                                    >

                                    @error('filter.email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="btn-group btn-group-sm">
                                        <button type="submit" class="btn btn-success">{{ __('Search') }}</button>
                                        <a href="{{ route('users.index') }}" class="btn btn-link">{{ __('Clear') }}</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="card">
                    <div class="card-header">Users</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No se encontraron usuarios</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $users->appends(request()->only('filter'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection