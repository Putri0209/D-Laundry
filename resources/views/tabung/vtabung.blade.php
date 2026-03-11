<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h2>Volume Tabung</h2>
    <a href="{{ url('navbar') }}">Kembali</a><br>
    <form action="{{ route('vtabung.store') }}" method="post">
        @csrf
        <label for="">Jari-Jari</label><br>
        <input type="number" name="jari" required><br>
        <label for="">Tinggi</label><br>
        <input type="number" name="tinggi" required><br>
        <button type="submit">Hitung</button>
    </form>
    @isset($hasil)
        <h3>Hasil : {{ $hasil }} </h3>
    @endisset
</body>

</html>
