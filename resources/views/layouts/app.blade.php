<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gemeente Zuidplas - Klachtenportaal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f7fa;
        }
        header, footer {
            text-align: center;
            padding: 15px;
            background-color: #004aad;
            color: white;
            border-radius: 10px;
        }
        main {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        a {
            color: #004aad;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        button {
            background: #004aad;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #00337a;
        }
        input, textarea {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
    </style>
</head>
<body>
<header>
    <h1>Gemeente Zuidplas - Klachtenportaal</h1>
</header>

<main>
    @yield('content')
</main>

<footer>
    <p>&copy; {{ date('Y') }} Gemeente Zuidplas</p>
</footer>
</body>
</html>
