<x-layouts.app title="Profile {{Auth::user()->name}}" pageTitleName="Profile {{Auth::user()->name}}">
    @push('style')

    @endpush

    <div class="content-card">
        <div class="row border p-3">
            <div class="col-xl-4 col-lg-12 d-flex" style="height: 200px;">
                <div class="mx-auto">
                    <img src="" alt="foto">
                </div>
            </div>
            <div class="col-xl-8 col-lg-12">
                @hasanyrole('guru')
                <div class="row">
                    <div class="d-flex flex-column col mb-3">
                        <label class="form-label" for="nama">Nama</label>
                        <input class="form-control" type="text" value="{{$data->guru->name}}" readonly>
                    </div>
                    <div class="d-flex flex-column col mb-3">
                        <label class="form-label" for="nisn">NIP</label>
                        <input class="form-control" type="text" value="{{$data->guru->nip}}" readonly>
                    </div>
                </div>
                @endhasanyrole

                @hasanyrole('siswa')
                <div class="row">
                    <div class="d-flex flex-column col mb-3">
                        <label class="form-label" for="nama">Nama</label>
                        <input class="form-control" type="text" value="{{$data->siswa->name}}" readonly>
                    </div>
                    <div class="d-flex flex-column col mb-3">
                        <label class="form-label" for="nisn">NISN</label>
                        <input class="form-control" type="text" value="{{$data->siswa->nisn}}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex flex-column col mb-3">
                        <label class="form-label" for="kelas">Kelas</label>
                        <input class="form-control" type="text" value="{{$data->siswa->kelas->name}}" readonly>
                    </div>
                    <div class="d-flex flex-column col mb-3">
                        <label class="form-label" for="jurusan">Jurusan</label>
                        <input class="form-control" type="text" value="{{$data->siswa->jurusan->name}}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex flex-column col mb-3">
                        <label class="form-label" for="ttl">Tempat Tanggal Lahir</label>
                        <input class="form-control" type="text" value="{{$data->siswa->tempat_lahir ?? '-' . $data->siswa->tanggal_lahir ?? '-'}}" readonly>
                    </div>
                    <div class="d-flex flex-column col mb-3">
                        <label class="form-label" for="tlp">No HP</label>
                        <input class="form-control" type="text" value="{{$data->siswa->no_telepon}}" readonly>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <label class="form-label" for="alamat">Alamat</label>
                    <input class="form-control" type="text" value="{{$data->siswa->alamat}}" readonly>
                </div>
                @endhasanyrole
            </div>
        </div>
    </div>

    @push('script')
    <script>

    </script>
    @endpush
</x-layouts.app>
