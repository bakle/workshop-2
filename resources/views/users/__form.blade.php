@csrf
<div class="form-group row">
    <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ ('First Name') }}</label>

    <div class="col-md-6">
        <input
                id="first_name"
                type="text"
                class="form-control @error('first_name') is-invalid @enderror"
                name="first_name"
                value="{{ old('first_name', $user->first_name) }}"
                required>

        @error('first_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

    <div class="col-md-6">
        <input
                id="last_name"
                type="text"
                class="form-control @error('last_name') is-invalid @enderror"
                name="last_name"
                value="{{ old('last_name', $user->last_name) }}"
                required>

        @error('last_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

    <div class="col-md-6">
        <input
                id="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                name="email"
                value="{{ old('email', $user->email) }}" required
        >

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

    <div class="col-md-6">
        <select id="country" name="country" class="custom-select @error('country') is-invalid @enderror">
            @foreach($countries as $country)
                <option value="{{ $country->id }}" @if($country->id === old('country', $user->country_id)) selected @endif>{{ $country->name }}</option>
            @endforeach
        </select>

        @error('country')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

    <div class="col-md-6">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" @if(!$user->exists()) required @endif>

        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

    <div class="col-md-6">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" @if(!$user->exists()) required @endif autocomplete="new-password">
    </div>
</div>