<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? '' }}</title>
</head>
<body>
    <h3>{{ $title ?? '' }}</h3>
    <a href="{{ route('siswa.create') }}">Tambah Siswa</a>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nilai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $index => $key )
            <tr>
                <td>{{ $index +=1 }}</td>
                <td>{{ $key['nama']}}</td>
                <td>{{ $key['nilai'] }}</td>
                <td>
                    {{-- {{ $status = item['nilai']>=90 ? 'Lulus' : 'Tidak Lulus' }} --}}
                    @if ($key['nilai'] >=90)
                    <span>Lulus</span>
                    @else
                    <span>Tidak Lulus</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>