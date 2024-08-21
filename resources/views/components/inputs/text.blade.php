<div class="{{ $class ?? 'row mb-3' }}">
    <div class="col-md-3 col-xxl-2 text-md-end">
        <label for="{{ $key }}" class="col-form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    </div>
    <div class="col-md-9 col-xl-8">
        <input id="{{ $key }}" name="{{ $key }}" type="{{ $type }}" class="form-control @error($key) is-invalid @enderror"
               minlength="{{ $min }}" {!! $max ? sprintf('maxlength="%s"', $max) : '' !!}
               placeholder="{{ $placeholder }}" value="{{ $value }}" @required($required)>
        @error($key)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @elseif($info)
            <div class="form-text text-muted smaller">
                <i class="fas fa-fw fa-info-circle"></i> {{ $info }}
            </div>
        @enderror
    </div>
</div>