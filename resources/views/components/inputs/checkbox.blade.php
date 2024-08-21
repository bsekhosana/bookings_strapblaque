<div class="{{ $class ?? 'row mb-3 align-items-center' }}">
    <div class="offset-md-3 offset-xxl-2 col-xl-8">
        <div class="form-check form-switch form-switch-md">
            <input type="hidden" name="{{ $key }}" value="0">
            <input class="form-check-input" type="checkbox" role="switch" id="{{ $key }}" name="{{ $key }}" value="1" {{ $value ? 'checked' : null }}>
            <label class="form-check-label ms-2 mt-1" for="{{ $key }}">{{ $label }}</label>
        </div>
    </div>
</div>