<x-public-page title="{{ $school['name'] }} | ELT Search" :dontIndex="true">
    <div class="max-w-5xl mx-auto py-20 px-6">
        <div class="flex flex-col items-center">
            <div class="w-40 h-40">
                <img src="{{ $school['logo']['thumb'] }}"
                     alt="{{ $school['name'] }} logo" class="w-full h-full object-contain">
            </div>
            <h1 class="type-h2 text-navy text-center leading-none my-4">{{ $school['name'] }}</h1>
            <p class="type-b2 text-navy">{{ $school['location'] }}</p>
            <p class="type-b2 mt-1 text-gray-600">{{ implode(", ", $school['school_types']) }}</p>
        </div>

        <div class="my-12 max-w-xl mx-auto">
            {!! $school['introduction'] !!}
        </div>

        <div class="my-12 flex justify-center max-w-5xl mx-auto" x-data="schoolImages()">
            @foreach($school['images'] as $image)
                <div class="w-1/4 mx-4">
                    <img src="{{ $image['thumb'] }}" alt="{{ $school['name'] }}" class="w-full h-full object-cover" @click="showImage('{{ $image['original'] }}')">
                </div>
            @endforeach
            <div class="fixed inset-0 bg-black bg-opacity-75 w-full h-full flex justify-center items-center" x-show="show" @keydown.escape.window="show = false">
                <button x-cloak type="button" class="m-6 bg-white shadow-lg rounded-l-full rounded-r-full px-6 py-2 absolute top-16 right-0 hover:bg-baby-blue focus:outline-none" @click="show = false">X</button>
                <div class="max-w-4xl max-h-full">
                    <img :src="source"
                         alt="" class="w-full h-full object-contain">
                </div>

            </div>

        </div>
    </div>
    <script>
        function schoolImages() {
            return {
                show: false,
                source: '{{ $school['images'][0]['original'] ?? "" }}',
                showImage(s) {
                    this.source = s;
                    this.show = true;
                }
            };
        }
    </script>

</x-public-page>
