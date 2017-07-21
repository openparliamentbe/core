<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nonexistent resource</title>

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
    </style>
</head>
<body>
    <p>The resource you are looking for does not exist.</p>
</body>
</html>
