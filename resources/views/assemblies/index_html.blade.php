<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of assemblies</title>
</head>
<body>
    <table>
        <caption>The list of assemblies</caption>
        <thead>
            <tr>
                <th>Identifier</th>
                <th>English name</th>
                <th>French name</th>
                <th>Dutch name</th>
            </tr>
        </thead>
        <tbody>

        @foreach ($assemblies as $assembly)
            <tr>
                <td>{{ $assembly->id }}</td>
                <td>{{ $assembly->name_en }}</td>
                <td>{{ $assembly->name_fr }}</td>
                <td>{{ $assembly->name_nl }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
</body>
</html>
