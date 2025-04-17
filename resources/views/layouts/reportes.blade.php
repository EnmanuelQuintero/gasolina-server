<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>

        <!-- Vite CSS -->
        @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }
        body {
            font-size: 10px;
            line-height: 1.2;
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .header {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    

        @yield ('content')


</body>
</html>