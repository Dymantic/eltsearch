<div {{ $attributes->merge(['class' => $wrapperClasses()]) }}>
    <label class="">
        <span class="text-sm font-bold">{{ $label }}</span>
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
            class="mt-1 w-full block border p-2 bg-transparent"
        >
            <option value
                    :selected="!$value"
            ><span class="text-gray-500">{{ $prompt }}</span></option
            >
            @foreach($options as $val => $option)
                <option
                    :selected="$value == $val"
                    :value="$val"
                >{{ $option }}</option
                >
            @endforeach
        </select>
    </label>
</div>
