<div class="{{ $class ?? 'row mb-3 align-items-center' }}">
    <div class="col-md-3 col-xxl-2 text-md-end">
        <label for="{{ $key }}" class="col-form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    </div>
    <div class="col-md-9 col-xl-8">
        <textarea id="{{ $key }}" name="{{ $key }}" class="form-control lh-base @error($key) is-invalid @enderror"
                  rows="{{ $rows }}" minlength="{{ $min }}" {!! $max ? sprintf('maxlength="%s"', $max) : '' !!}
                  placeholder="{{ $placeholder }}" @required($required)>{{ $value }}</textarea>
        @error($key)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>