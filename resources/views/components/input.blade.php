@props(['name', 'label' => '', 'class' => '', 'type' => 'text', 'value' => ''])

<div class="mb-3">
    @isset($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endisset
    <input class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $name }}"
        type="{{ $type }}" placeholder="{{ $label }}" value="{{ old($name, $value) }}" />
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
