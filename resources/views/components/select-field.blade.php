<div {{ $attributes->merge(['class' => $wrapperClasses()]) }}>
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
        <select
            class="form-text-input bg-transparent"
            name="{{ $name }}"
        >
            <option value="" @if(!$value) selected @endif
            ><span class="text-gray-500">{{ $prompt }}</span></option
            >
            @foreach($options as $val => $option)
                <option @if($value == $val) selected @endif
                    value="{{ $val }}"
                >{{ $option }}</option
                >
            @endforeach
        </select>
    </label>
</div>
