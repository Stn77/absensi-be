<x-layouts.app title="Absensi Siswa" pageTitleName="Absensi Siswa">
    <div class="content-card">

        <div class="border my-2 row">
            <form action="" class="col-xl-6 row d-flex align-items-center">
                <div class="col-xl-4 col-lg-6">
                    <label for="kelasFilter" class="form-label">Kelas</label>
                    <select name="kelasFilter" id="kelasFilter" class="form-select form-control form-control-sm">
                        <option value="" selected disabled>Pilih Kelas</option>
                        @foreach ($kelas as $kl)
                        <option value="{{$kl->id}}">{{strtoupper($kl->name)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <label for="jurusanFilter" class="form-label">Jurusan</label>
                    <select name="jurusanFilter" id="jurusanFilter" class="form-select form-control form-control-sm">
                        <option value="" selected disabled>Pilih Jurusan</option>
                        @foreach ($jurusan as $jr)
                        <option value="{{$jr->id}}">{{strtoupper($jr->name)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-4 col-lg-6 mt-4 d-flex gap-2">
                    <button class="btn btn-primary btn-sm">Filter</button>
                    <button class="btn btn-secondary btn-sm">Reset</button>
                </div>
            </form>
            <div class="col-xl-6 d-flex align-items-center justify-content-end">
                <div>
                    <a href="{{route('admin.absensi.export-page')}}" class="btn btn-primary " data-bs-toggle="exportMode" data-bs-target="hehe">Export</a>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column mt-3">
            <div class="table-responsive">
                <table class="table" id="absensiswa">
                    <thead></thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exportMode" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">

    </div>

    @push('script')
    <script>
        $(document).ready(() => {
            let absenSiswaTable = $('#absensiswa').DataTable({
                processing: true,
                pageLength: 50,
                serverSide: true,
                autoFill: false,
                ajax: {
                    url: '{{ route('admin.absensi.data') }}',
                    data: function(d){
                        d.kelas = $('#kelasFilter').val()
                        d.jurusan = $('#jurusanFilter').val()
                    },
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        title: 'No',
                        orderable: false,
                        width: '3%',
                    },
                    {
                        data: 'siswa.nisn',
                        title: 'NISN',
                        width: '10%',
                    },
                    {
                        data: 'siswa.name',
                        title: 'Nama Siswa',
                        width: '20%',
                    },
                    {
                        data: 'hari',
                        title: 'Hari',
                        width: '5%',
                    },
                    {
                        data: 'tanggal',
                        title: 'Tanggal',
                        width: '10%',
                    },
                    {
                        data: 'kelas',
                        title: 'Kelas',
                        width: '5%',
                    },
                    {
                        data: 'waktu_absen',
                        title: 'Waktu',
                        width: '5%',
                        render: function(data, type, row){
                            return data + " WIB";
                        }
                    },
                    {
                        data: 'koordinat',
                        title: 'Detail',
                        width: '5%',
                        render: function(data, type, row){
                            return `<a target="blank" class="btn btn-sm btn-primary" href="${data}">Koordinat</a>`
                        }
                    },
                    {
                        data: 'is_late',
                        title: 'Is Late',
                        width: '5%',
                        render: function(data, type, row){
                            if(data === 'Tepat Waktu'){
                                return `<span class="badge text-bg-primary" >${data}</span>`
                            } else {
                                return `<span class="badge text-bg-danger" >${data}</span>`
                            }
                        }
                    },
                    {
                        data: 'jenis',
                        title: 'Jenis',
                        width: '5%',
                        render: function(data, type, row){
                            if(data === 'datang'){
                                return `<span class="badge text-bg-primary text-white" >${data}</span>`
                            } else {
                                return `<span class="badge text-bg-danger" >${data}</span>`
                            }
                        }
                    }
                ]
            });
        });

    </script>
    @endpush

</x-layouts.app>
