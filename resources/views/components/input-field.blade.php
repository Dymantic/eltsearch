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
        <input
            name="{{ $name }}"
            type="{{ $inputType() }}"
            value="{{ $value }}"
            class="form-text-input"
            @if($isBound()) x-model="{{ $modelBinding() }}" @endif
        />
    </label>
</div>
