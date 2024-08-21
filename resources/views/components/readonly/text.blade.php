<div class="{{ $class ?? 'row mb-3' }}">
    <div class="col-md-3 col-xxl-2 text-md-end">
        <label for="{{ $key }}" class="col-form-label">{{ $label }}</label>
    </div>
    <div class="col-md-9 col-xl-8">
        <input id="{{ $key }}" name="{{ $key }}" type="{{ $type ?? 'text' }}" class="form-control" value="{{ $value }}" readonly>
        @if($info)
            <div class="form-text text-muted smaller">
                <i class="fas fa-fw fa-info-circle"></i> {{ $info }}
            </div>
        @endif
    </div>
</div>