<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h4>Edit Volume Limas Segi Empat</h4>
    <form action="{{ route('vlimas.update', $limas->id) }}" method="post">
        @csrf
        @method('PUT')
        <label for="">Luas Alas</label><br>
        <input type="number" step="any" name="luas_alas" value="{{ $limas->luas_alas }}"><br>
        <label for="">Tinggi</label><br>
        <input type="number" name="tinggi" value="{{ $limas->tinggi }}"><br>
        <button type="submit">Hitung & Simpan</button>
    </form>
</body>
</html>