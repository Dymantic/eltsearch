<div {{ $attributes->merge(['class' => $wrapperClasses]) }}>
    <label class="">
        <span class="form-label">{{ $label }}</span>
        @if($errors->has($name))
            <span class="text-xs text-red-400">{{
                $errors->first($name)
            }}</span>
        @endif
        @if($helpText)
            <p class="my-1 text-gray-500 text-sm">
                {{ $helpText }}
            </p>
        @endif
        <textarea
            name="{{ $name }}"
            class="form-text-input {{ $height }}"
        >{{ $value }}</textarea>
    </label>
</div>
