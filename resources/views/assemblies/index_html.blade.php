<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of assemblies</title>

    <style>
        /* Create a small Belgian flag at the top of the page. */
        html:before {
            content: '';
            display: block;
            height: 3px;
            background-image: linear-gradient(
                to right,
                #000, #000 33%,
                #ffe936 33%, #ffe936 66%,
                #ff0f21 66%, #ff0f21
            );
            box-shadow: 0 1px 5px rgba(0,0,0,.15);
        }
        body {
            margin: 1em;
            background-color: #ebebeb;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #333;
        }
        table {
            margin: 2em auto;
            border: 1px solid #ddd;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 1px 5px rgba(0,0,0,.15);
            color: #333;
        }
        caption {
            font-family: "Times New Roman", Times, Baskerville, Georgia, serif;
            font-size: 1.5em;
            line-height: 2;
            font-style: italic;
            color: #000;
        }
        thead tr {
            border-bottom: 1px solid #555;
        }
        tr {
            border-bottom: 1px solid #ddd;
        }
        th {
            color: #000;
        }
        th, td {
            padding: .5em .75em;
            border-left: 1px solid #ddd;
        }
        a.link {
            border-bottom: 1px solid transparent;
            color: #0f88ff;
            text-decoration: none;
        }
        a.link:hover {
            border-bottom-color: currentColor;
        }
    </style>
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
                <td>
                    <a href="/assemblies/{{ $assembly->id }}" class="link">
                        {{ $assembly->id }}
                    </a>
                </td>
                <td>{{ $assembly->name_en }}</td>
                <td>{{ $assembly->name_fr }}</td>
                <td>{{ $assembly->name_nl }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
</body>
</html>
