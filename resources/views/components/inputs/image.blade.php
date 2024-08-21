<div class="{{ $class ?? 'row mb-3' }}">
    <div class="col-md-3 col-xxl-2 text-md-end">
        <label for="{{ $key }}" class="col-form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    </div>
    <div class="col-md-9 col-xl-8">
        <input id="{{ $key }}" name="{{ $key }}" type="file" accept="image/png,image/gif,image/jpeg,image/svg+xml"
               class="form-control @error($key) is-invalid @enderror" @required($required)>
        @error($key)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>