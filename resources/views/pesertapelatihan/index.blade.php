<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

        <style>
            table{
                border: 1px solid black;
                text-align: center;
            }
        </style>
</head>
<body>
<h2>Peserta Pelatihan PPKD Jakpus</h2>
<a href="{{ route('pesertapelatihan.create') }}">Tambah Data</a>
<table class="table-primary">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Lengkap</th>
        <th>Jenis Kelamin</th>
        <th>Kejuruan</th>
        <th>Pendidikan Terakhir</th>
        <th>Nomor HP</th>
        <th>Email</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    </thead>
    @foreach ($peserta as $index =>$v)
    <tr>
        <td>{{ $index+1 }}</td>
        <td>{{ $v->nama_lengkap }}</td>
        <td>{{ $v->jenis_kelamin }}</td>
        <td>{{ $v->kejuruan }}</td>
        <td>{{ $v->pendidikan_terakhir }}</td>
        <td>{{ $v->nomor_hp }}</td>
        <td>{{ $v->email }}</td>
        <td>{{ $v->status }}</td>
        <td>
            <a href="{{ route('pesertapelatihan.edit', $v->id) }}">Edit</a>
            <form action="{{ route('pesertapelatihan.destroy', $v->id) }}" method="post" onclick="return confirm('Yakin ingin di hapus?')">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>
</html>