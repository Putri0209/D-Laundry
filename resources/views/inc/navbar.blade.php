<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Belajar Berhitung di Laravel</h1>
    <nav>
        <a href="{{ route('perhitungan.index') }}">Perhitungan</a> ||
        <a href="{{ route('kubus.index') }}">Luas Permukaan Kubus</a> ||
        <a href="{{ route('vkubus.index') }}">Volume Kubus</a> ||
        <a href="{{ route('lptabung.index') }}">Luas Permukaan Tabung</a> ||
        <a href="{{ route('vtabung.index') }}">Volume Tabung</a>||
        <a href="{{ route('vlimas.index') }}">Volume Limas Segi Empat</a>

    </nav>
</body>

{{-- {{ route('vlimas.index') }} --}}
</html>

