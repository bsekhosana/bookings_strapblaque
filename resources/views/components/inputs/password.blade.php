<div class="{{ $class ?? 'row mb-3' }}">
    <div class="col-md-3 col-xxl-2 text-md-end">
        <label for="{{ $key }}" class="col-form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    </div>
    <div class="col-md-9 col-xl-8">
        <input id="{{ $key }}" name="{{ $key }}" type="password" class="form-control @error('password') is-invalid @enderror"
               placeholder="{{ $placeholder }}" @required($required)>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

@if($confirm)
    <div class="row mb-3">
        <div class="col-md-3 col-xxl-2 text-md-end">
            <label for="{{ $key }}_confirmation" class="col-form-label {{ $required ? 'required' : '' }}">{{ $confirm_label }}</label>
        </div>
        <div class="col-md-9 col-xl-8">
            <input id="{{ $key }}_confirmation" name="{{ $key }}_confirmation" type="password" class="form-control" placeholder="{{ $placeholder }}" @required($required)>
        </div>
    </div>
@endif