<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assembly {{ $assembly->id }}</title>

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
            margin: 2em;
            background-color: #fff;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #333;
        }
        h1 {
            margin-top: 0;
            color: #000;
        }
        dt {
            font-weight: bold;
            color: #000;
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
    <h1>Assembly {{ $assembly->id }}</h1>
    <dl>
        <dt>English name</dt>
        <dd>{{ $assembly->name_en }}</dd>
        <dt>French name</dt>
        <dd>{{ $assembly->name_fr }}</dd>
        <dt>Dutch name</dt>
        <dd>{{ $assembly->name_nl }}</dd>
    </dl>
    <p class="links">
        <a href="/assemblies" class="link">View the full list of assemblies</a>
    </p>
</body>
</html>
