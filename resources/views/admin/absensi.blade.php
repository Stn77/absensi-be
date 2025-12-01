<x-layouts.app title="Absensi Siswa" pageTitleName="Absensi Siswa">
    <div class="content-card">
        <div class="d-flex flex-column">
            <div class="table-responsive">
                <table class="table" id="absensiswa">
                    <thead></thead>
                </table>
            </div>
        </div>
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
                    },
                    { data: 'siswa.nisn', title: 'NISN' },
                    { data: 'siswa.name', title: 'Nama Siswa' },
                    { data: 'hari', title: 'Hari' },
                    { data: 'created_at', title: 'Tanggal' },
                    { data: 'siswa.jurusan.name', title: 'Jurusan' },
                    { data: 'siswa.kelas.name', title: 'Kelas' },
                    { data: 'waktu_absen', title: 'Waktu' },
                ]
            });
        });

    </script>
    @endpush

</x-layouts.app>
