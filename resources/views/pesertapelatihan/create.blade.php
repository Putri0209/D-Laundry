<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<style>
    body{
        display: flex;

    }
</style>

<body>


    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h4>Tambah Peserta Pelatihan</h4>
                </div>
            </div>
            <form action="{{ route('pesertapelatihan.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Jurusan</label>
                        <select class="form-select" name="jurusan">
                            <option value="">--Pilih Jurusan--</option>
                            <option value="Web Programming">Web Programming</option>
                            <option value="Content Creator">Content Creator</option>
                            <option value="Multimedia">Multimedia</option>
                            <option value="Teknisi Komputer">Teknisi Komputer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Gelombang</label><br>
                        <select class="form-select" name="gelombang">
                            <option value="">--Pilih Gelombang--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap">
                    </div>
                    <div class="form-group">
                        <label for="">NIK</label>
                        <input type="number" class="form-control" name="nik">
                    </div>
                    <div class="form-group">
                        <label for="">Kartu Keluarga</label>
                        <input type="text" class="form-control" name="kartu_keluarga">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Kelamin</label><br>
                        <select class="form-select" name="jenis_kelamin">
                            <option value="">--Pilih--</option>
                            <option value="laki-laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir">
                    </div>
                    <div class="form-group">
                        <label for="">Pendidikan Terakhir</label>
                        <select class="form-select" name="pendidikan_terakhir">
                            <option value="">--Pilih--</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA/SMK">SMA/SMK</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Sekolah</label>
                        <input type="text" class="form-control" name="nama_sekolah">
                    </div>
                    <div class="form-group">
                        <label for="">Kejuruan</label>
                        <input type="text" class="form-control" name="kejuruan">
                    </div>
                    <div class="form-group">
                        <label for="">Nomor HP</label>
                        <input type="number" class="form-control" name="nomor_hp">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label for="">Aktivitas Saat Ini</label>
                        <input type="text" class="form-control" name="aktivitas_saat_ini">
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <select class="form-select" name="status">
                            <option value="">--Pilih--</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <input type="text" class="form-control" name="status">
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-primary" name="">Simpan</button>

                    <a href="?page=user" class="btn btn-danger">Batalkan</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
