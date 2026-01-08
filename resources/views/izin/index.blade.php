<x-layouts.app title="Daftar Pengajuan Izin">
    <div class="d-flex flex-column">
        <div class="mb-4 d-flex">
            <div class="flex-row filter d-flex form-group">
                @hasanyrole('admin|teacher')
                <div class="jurusan-f me-2 form-group">
                    <select class="form-select form-select-sm me-2" name="kelas" id="kelasFilter" aria-placeholder="konz">
                        <option value="">kelas</option>
                        <option value="1">X</option>
                        <option value="2">XI</option>
                        <option value="3">XII</option>
                    </select>
                </div>
                <div class="kelas-f me-2 form-group">
                    <select class="form-select form-select-sm me-2" name="jurusan" id="jurusanFilter">
                        <option value="">Jurusan</option>
                        <option value="1">MP</option>
                        <option value="2">AK</option>
                        <option value="3">BD</option>
                        <option value="4">TSM</option>
                        <option value="5">DKV</option>
                        <option value="6">PPLG</option>
                        <option value="7">tkkr</option>
                    </select>
                </div>
                @endhasanyrole

                @hasanyrole('admin')

                @endhasanyrole
            </div>
        </div>
        <div class="table-responsive">
            <table class="table mt-2 table-striped table-bordered" id="izinSiswa">
                <thead class="mt-2 text-light table-dark" style="background-color: rgb(32, 32, 32);"></thead>
            </table>
        </div>
    </div>

    @push('script')
        @hasanyrole('siswa')
        <script type="module">
            $(document).ready(() => {
                let tabelIzin = $('#izinSiswa').Datatable({
                processing: true,
                pageLength: 50,
                serverSide: true,
                autoFill: false,
                ajax: {
                    url: ,
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        title: 'No',
                        orderable: false,
                    },

                    { data: 'action', title: 'Ket', orderable: false, searchable: false },
                ]
                })
            })
        </script>
        @endhasanyrole
    @endpush
</x-layouts.app>
