<div class="{{ $class ?? 'row mb-3' }}">
    <div class="col-md-3 col-xxl-2 text-md-end">
        <label for="{{ $key }}" class="col-form-label">{{ $label }}</label>
    </div>
    <div class="col-md-9 col-xl-8">
        <div class="form-control lh-base">{!! $value ?? '&nbsp;' !!}</div>
        @if($info)
            <div class="form-text text-muted smaller">
                <i class="fas fa-fw fa-info-circle"></i> {{ $info }}
            </div>
        @endif
    </div>
</div>