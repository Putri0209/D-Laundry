<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? '' }}</title>
</head>
<body>
    <h3>Tambah Siswa</h3>
    <form action="{{ route('siswa.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Nama</label>
            <input type="text" name="nama" placeholder="Masukkan Nama" required>
        </div>
        <br>
        <div class="form-group">
            <label for="">Nilai</label>
            <input type="number" name="nilai" placeholder="Masukkan Nilai" required>
        </div>
        <br>
        <div class="form-group">
            <button type="submit">Simpan</button>
        </div>
    </form>
</body>
</html>