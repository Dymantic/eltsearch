<div>
    <p class="type-h2 text-center mt-6">Step {{ $step }}</p>
    <div class="w-32 flex justify-around mx-auto  mb-12">
        @foreach(range(1, $of) as $point)
        <div class="h-3 w-3 {{ $colourForPosition($point) }} rounded-full"></div>
        @endforeach
    </div>
</div>
