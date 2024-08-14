@props([
    'label' => '',
    'value' => '',
    'dir' => 'horizontal',
    'class' => '',
])
<div class="{{ ($dir == 'horizontal') ? 'd-flex' : 'd-block'}} mb-2 {{ $class }}">
    <div class="w-50">
        {{ $label }}
    </div>
    <div class="mx-2">:</div>
    <div class="fw-semibold text-start">
        {!! $value !!}
    </div>
</div>