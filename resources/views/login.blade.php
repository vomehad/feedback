@extends('layouts.app')
@section('title', $title)
@section('content')
    <form action="{{ route('api.login') }}" class="col-6 offset-2 border rounded" method="POST">

        @csrf

        <div class="form-group">
            <label for="email" class="col-form-label-lg">{{ __('message.label.email') }}</label>
            <input type="email"
                   class="form-control @error('email') border-danger @enderror"
                   name="email"
                   id="email"
                   value=""
                   placeholder="{{ __('message.placeholder.email') }}"
            />
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="col-form-label-lg">{{ __('message.label.password') }}</label>
            <input type="password"
                   class="form-control @error('password') border-danger @enderror"
                   name="password"
                   id="password"
                   value=""
                   placeholder="{{ __('message.placeholder.password') }}"
            />
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button class="btn btn-primary"
                    type="submit"
                    name="sendMe"
                    value="1"
            >{{ __('message.send.login') }}</button>
        </div>

    </form>
@endsection
