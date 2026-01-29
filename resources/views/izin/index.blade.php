<x-layouts.app title="Daftar Pengajuan Izin">
    <div class="d-flex flex-column">
        <div class="mb-4 d-flex">
            <div class="flex-row filter d-flex form-group">

                @hasanyrole('admin|guru')
                <div class="jurusan-f me-2 form-group">
                    <select class="form-select form-select-sm me-2" name="kelas" id="kelasFilter">
                        <option value="">Semua Kelas</option>
                        <option value="1">X</option>
                        <option value="2">XI</option>
                        <option value="3">XII</option>
                    </select>
                </div>

                <div class="kelas-f me-2 form-group">
                    <select class="form-select form-select-sm me-2" name="jurusan" id="jurusanFilter">
                        <option value="">Semua Jurusan</option>
                        <option value="1">MP</option>
                        <option value="2">AK</option>
                        <option value="3">BD</option>
                        <option value="4">TSM</option>
                        <option value="5">DKV</option>
                        <option value="6">PPLG</option>
                        <option value="7">TKKR</option>
                    </select>
                </div>
                @endhasanyrole

            </div>
        </div>

        <div class="table-responsive">
            <table class="table mt-2 table-striped table-bordered" id="izinSiswa" style="width:100%">
                <thead class="table-dark"></thead>
            </table>
        </div>
    </div>

    @push('script')
    <script>
        $(document).ready(function () {

            let tabelIzin = $('#izinSiswa').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: {
                    url: "{{ route('siswa.izin.list.fetch') }}",
                    data: function(d) {
                        d.kelas = $('#kelasFilter').val();
                        d.jurusan = $('#jurusanFilter').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', title: 'No', orderable: false },

                    { data: 'nama', title: 'Nama' },

                    { data: 'kelas', title: 'Kelas' },

                    { data: 'jenis', title: 'Jenis Izin' },

                    { data: 'keperluan', title: 'Keperluan' },

                    { data: 'from_date', title: 'Mulai' },

                    { data: 'until_date', title: 'Sampai' },

                    { data: 'action', title: 'Aksi', orderable: false }
                ]
            });

            $('#kelasFilter, #jurusanFilter').on('change', function () {
                tabelIzin.ajax.reload();
            });

        });
    </script>
    @endpush
</x-layouts.app>
