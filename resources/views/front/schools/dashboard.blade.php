<x-public-page>
    <h1>hello school. Or should  say 'Ni Hau'?</h1>


    <form action="/logout" method="post">
        {!! csrf_field() !!}
        <button type="submit">Logout</button>
    </form>
</x-public-page>
