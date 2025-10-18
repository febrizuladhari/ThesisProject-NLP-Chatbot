@props([
    'id' => 'password',
    'name' => 'password',
    'label' => 'Password',
    'required' => false,
    'placeholder' => '',
    'value' => '',
    'showLabel' => true,
    'helpText' => '',
    'icon' => 'bi-lock',
])

@if ($showLabel)
    <label for="{{ $id }}" class="form-label">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif

<div class="input-group">
    <span class="input-group-text">
        <i class="bi {{ $icon }}"></i>
    </span>
    <input type="password" class="form-control @error($name) is-invalid @enderror" id="{{ $id }}"
        name="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }} {{ $attributes }}>
    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="{{ $id }}">
        <i class="bi bi-eye"></i>
    </button>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@if ($helpText)
    <small class="text-muted d-block mt-1">{{ $helpText }}</small>
@endif

@push('styles')
    <style>
        .toggle-password {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-password:hover {
            background-color: #e9ecef;
        }

        .toggle-password:active {
            transform: scale(0.95);
        }

        .toggle-password i {
            transition: all 0.3s ease;
        }
    </style>
@endpush
