<div class="{{ $class ?? 'row mb-3' }}">
    <div class="col-md-3 col-xxl-2 text-md-end">
        <label for="{{ $key }}" class="col-form-label">{{ $label }}</label>
    </div>
    <div class="col-md-9 col-xl-8">
        <select id="{{ $key }}" name="{{ $key }}[]" size="{{ $size }}" class="form-select" multiple readonly>
            @foreach($options as $loop_value => $loop_name)
                <option value="{{ $loop_value }}">{{ $loop_name }}</option>
            @endforeach
        </select>
    </div>
</div>