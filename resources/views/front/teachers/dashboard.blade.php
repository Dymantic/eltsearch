<x-public-page>
    <h1>Welcome to your dashboard</h1>

    <form action="/logout" method="post">
        {!! csrf_field() !!}
        <button type="submit">Logout</button>
    </form>
</x-public-page>
