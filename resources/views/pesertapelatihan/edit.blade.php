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

<body>


    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h4>Edit Peserta Pelatihan</h4>
                </div>
            </div>
            <form action="{{ route('pesertapelatihan.update', $peserta->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Jurusan</label>
                        <select class="form-select" name="jurusan">
                            <option value="">--Pilih Jurusan--</option>
                            <option value="Web Programming" <?php echo $peserta->jurusan == 'Web Programming' ? 'selected' : ''; ?>>Web Programming</option>
                            <option value="Content Creator" <?php echo $peserta->jurusan == 'Content Creator' ? 'selected' : ''; ?>>Content Creator</option>
                            <option value="Multimedia" <?php echo $peserta->jurusan == 'Multimedia' ? 'selected' : ''; ?>>Multimedia</option>
                            <option value="Teknisi Komputer" <?php echo $peserta->jurusan == 'Teknisi Komputer' ? 'selected' : ''; ?>>Teknisi Komputer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Gelombang</label><br>
                        <select class="form-select" name="gelombang">
                            <option value="">--Pilih Gelombang--</option>
                            <option value="1" <?php echo $peserta->gelombang == '1' ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?php echo $peserta->gelombang == '2' ? 'selected' : ''; ?>>2</option>
                            <option value="3" <?php echo $peserta->gelombang == '3' ? 'selected' : ''; ?>>3</option>
                            <option value="4" <?php echo $peserta->gelombang == '4' ? 'selected' : ''; ?>>4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap"
                            value="{{ $peserta->nama_lengkap }}">
                    </div>
                    <div class="form-group">
                        <label for="">NIK</label>
                        <input type="number" class="form-control" name="nik" value="{{ $peserta->nik }}">
                    </div>
                    <div class="form-group">
                        <label for="">Kartu Keluarga</label>
                        <input type="text" class="form-control" name="kartu_keluarga"
                            value="{{ $peserta->kartu_keluarga }}">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Kelamin</label><br>
                        <select class="form-select" name="jenis_kelamin">
                            <option value="">--Pilih--</option>
                            <option value="laki-laki" <?php echo $peserta->jenis_kelamin == 'laki-laki' ? 'selected' : ''; ?>>Laki-Laki</option>
                            <option value="perempuan" <?php echo $peserta->jenis_kelamin == 'perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir"
                            value="{{ $peserta->tempat_lahir }}">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir"
                            value="{{ $peserta->tanggal_lahir }}">
                    </div>
                    <div class="form-group">
                        <label for="">Pendidikan Terakhir</label>
                        <select class="form-select" name="pendidikan_terakhir">
                            <option value="">--Pilih--</option>
                            <option value="SD" <?php echo $peserta->pendidikan_terakhir == 'SD' ? 'selected' : ''; ?>>SD</option>
                            <option value="SMP" <?php echo $peserta->pendidikan_terakhir == 'SMP' ? 'selected' : ''; ?>>SMP</option>
                            <option value="SMA/SMK" <?php echo $peserta->pendidikan_terakhir == 'SMA/SMK' ? 'selected' : ''; ?>>SMA/SMK</option>
                            <option value="D3" <?php echo $peserta->pendidikan_terakhir == 'D3' ? 'selected' : ''; ?>>D3</option>
                            <option value="S1" <?php echo $peserta->pendidikan_terakhir == 'S1' ? 'selected' : ''; ?>>S1</option>
                            <option value="S2" <?php echo $peserta->pendidikan_terakhir == 'S2' ? 'selected' : ''; ?>>S2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Sekolah</label>
                        <input type="text" class="form-control" name="nama_sekolah"
                            value="{{ $peserta->nama_sekolah }}">
                    </div>
                    <div class="form-group">
                        <label for="">Kejuruan</label>
                        <input type="text" class="form-control" name="kejuruan" value="{{ $peserta->kejuruan }}">
                    </div>
                    <div class="form-group">
                        <label for="">Nomor HP</label>
                        <input type="number" class="form-control" name="nomor_hp" value="{{ $peserta->nomor_hp }}">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $peserta->email }}">
                    </div>
                    <div class="form-group">
                        <label for="">Aktivitas Saat Ini</label>
                        <input type="text" class="form-control" name="aktivitas_saat_ini"
                            value="{{ $peserta->aktivitas_saat_ini }}">
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <select class="form-select" name="status">
                            <option value="">--Pilih--</option>
                            <option value="Aktif" <?php echo $peserta->status == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="Tidak Aktif" <?php echo $peserta->status == 'Tidak Aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
                        </select>
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
