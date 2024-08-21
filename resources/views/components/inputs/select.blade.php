<div class="{{ $class ?? 'row mb-3' }}">
    <div class="col-md-3 col-xxl-2 text-md-end">
        <label for="{{ $key }}" class="col-form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    </div>
    <div class="col-md-9 col-xl-8">
        <select id="{{ $key }}" name="{{ $key }}" class="form-select @error($key) is-invalid @enderror" @required($required)>
            <option value="">Please select..</option>
            @foreach($options as $loop_value => $loop_name)
                @if($loop_value == $value)
                    <option value="{{ $loop_value }}" selected>{{ $loop_name }}</option>
                @else
                    <option value="{{ $loop_value }}">{{ $loop_name }}</option>
                @endif
            @endforeach
        </select>
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