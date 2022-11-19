@extends('layouts.app')
@section('title', $title)
@section('content')
    @php
    /** @var App\Models\Feedback $model */
    @endphp
    <form action="{{ route('feedbacks.store') }}" class="col-6 offset-2 border rounded" method="POST">

        @csrf

        <div class="form-group">
            <label for="phone" class="col-form-label-lg">{{ __('message.label.phone') }}</label>
            <input type="number"
                   class="form-control @error('phone') border-danger @enderror"
                   name="phone"
                   id="phone"
                   value=""
                   placeholder="{{ __('message.placeholder.phone') }}"
            />
            @error('phone')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="name" class="col-form-label-lg">{{ __('message.label.name') }}</label>
            <input type="text"
                   class="form-control @error('name') border-danger @enderror"
                   name="name"
                   id="name"
                   value=""
                   placeholder="{{ __('message.placeholder.name') }}"
            />
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-10 col-sm-12">
            <label for="message" class="form-label">{{ __('message.label.message') }}</label>
            <textarea name="message"
                      class="form-control @error('message') is-invalid @enderror"
                      placeholder="{{ __('message.placeholder.message') }}"
                      rows="16"
                      id="message"
            >{{ old('message', $model->message) }}</textarea>
        </div>
        @error('text')
        <div class="alert alert-danger">
            <span>{{ $message }}</span>
        </div>
        @enderror

        <div class="form-group">
            <button class="btn btn-primary"
                    type="submit"
                    name="sendMe"
                    value="1"
            >{{ __('message.send.login') }}</button>
        </div>

    </form>
@endsection
