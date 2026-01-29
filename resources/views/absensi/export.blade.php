<x-layouts.app title="Export Absensi Siswa" pageTitleName="Export Absensi Siswa">
    @push('style')
        <style>
            .card-export {
                width: 700px;
                border: 2px dashed #6c757d;
                border-radius: 8px;
                background-color: #f8f9fa;
            }
        </style>
    @endpush

    <div class="container-fluid py-3 d-flex align-items-start justify-content-center" style="min-height: 70vh;">
        <div class="card-export border shadow-sm">
            <form action="{{route('admin.absensi.exported')}}" method="GET" target="_blank">
                @csrf
                <div class="d-flex row p-4">
                    <div class="col-md-6 m-auto text-center py-4">
                        <p class="h2">Export Data Absensi</p>
                    </div>
                    <div class="d-flex row align-items-center justify-content-center mb-4">
                        <div class="col-md-6">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select name="kelas" id="kelas" class="form-select">
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}">{{ strtoupper($item->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select name="jurusan" id="jurusan" class="form-select">
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusan as $item)
                                    <option value="{{ $item->id }}">{{ strtoupper($item->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex row align-items-center justify-content-center mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="from_date">Dari Tanggal</label>
                            <input id="from_date" class="form-control" type="date" value="">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="to_date">Sampai Tanggal</label>
                            <input id="to_date" class="form-control" type="date" max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="d-flex row align-items-center justify-content-center mb-4">
                        <div class="">
                            <label for="file_type" class="form-label">Format File</label>
                            <select name="file_type" id="file_type" class="form-select">
                                <option value="">Pilih Format</option>
                                <option value="xlsx">Excel (.xlsx)</option>
                                <option value="pdf">PDF (.pdf)</option>
                            </select>
                        </div>
                    </div>
                    <div class="m-auto d-flex text-center align-items-end justify-content-end mb-2">
                        <button class="btn btn-primary" type="submit" id="exportData">Export Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
