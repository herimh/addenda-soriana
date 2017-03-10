<div>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Familia</th><th>Subfamilia</th><th>Nombre</th><th>Codigo</th><th>Imagen</th>
            </tr>
        </thead>
        <tbody>
            @foreach($flowers as $flower)
                <tr>
                    <td>{{ $flower->id }}</td>
                    <td>{{ $flower->family }}</td>
                    <td>{{ $flower->subfamily }}</td>
                    <td>{{ $flower->name }}</td>
                    <td>{{ $flower->code }}</td>
                    <td><a href="{{ asset('imagenes') }}/{{$flower->url}}">Imagen</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
