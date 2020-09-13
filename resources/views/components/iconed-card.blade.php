<div class="shadow-lg flex flex-col items-center w-64 p-4 rounded-lg m-4">
    @include("svg.icons.{$icon}", ['classes' => 'h-6 text-sky-blue'])
    <div class="my-2 type-h4">{{ $title }}</div>
    <p class="type-b1 text-center">{{ $slot }}</p>
</div>
