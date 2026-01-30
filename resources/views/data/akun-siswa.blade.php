<x-layouts.app title="Akun Siswa" pageTitleName="Akun Siswa" sidebarShow=true>
    @push('style')
    <style>
        .drag-drop-area {
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            padding: 3rem 2rem;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .drag-drop-area:hover {
            border-color: #007bff;
            background-color: #e6f3ff;
        }

        .drag-drop-area.drag-over {
            border-color: #007bff;
            background-color: #e6f3ff;
            border-style: solid;
            transform: scale(1.02);
        }

        .drag-drop-area.has-file {
            border-color: #28a745;
            background-color: #d4edda;
        }

        .file-input-hidden {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-icon {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .drag-over .upload-icon {
            color: #007bff;
            animation: bounce 0.6s ease-in-out;
        }

        .has-file .upload-icon {
            color: #28a745;
        }

        @keyframes bounce {
            0%, 20%, 60%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            80% { transform: translateY(-5px); }
        }

        .file-info {
            display: none;
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin-top: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .file-info.show {
            display: block;
        }

        .remove-file {
            color: #dc3545;
            cursor: pointer;
            float: right;
            font-size: 1.2rem;
        }

        .remove-file:hover {
            color: #a71d2a;
        }

        .upload-text {
            font-size: 1.1rem;
            color: #495057;
            margin: 0.5rem 0;
        }

        .upload-subtext {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .progress {
            display: none;
            margin-top: 1rem;
        }

        .form-import-excel, #desktopTabContent{
            width: 100%;
        }
        .submit-multi-user{
            gap: 1rem;
        }

        .top {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        .foto-profile-c {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 3px solid #dee2e6;
        }

        .foto-profile-c img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .data-inti {
            flex: 1;
        }

        .daftar-kelas {
            margin: 0 20px 20px;
        }

        .modal {
            z-index: 1;
        }

        .modal-backdrop {
            z-index: 1;
            display: none;
        }

        .bi {
            color: white;
        }

        /* Responsive styles */
        @media (max-width: 1220px) {
            .top {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .foto-profile-c {
                width: 180px;
                height: 180px;
            }

            .data-inti {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .modal-dialog {
                margin: 10px;
            }

            .foto-profile-c {
                width: 150px;
                height: 150px;
            }

            .top {
                padding: 15px;
            }

            .daftar-kelas {
                margin: 0 10px 15px;
                padding: 15px !important;
            }
        }

        @media (max-width: 576px) {
            .foto-profile-c {
                width: 120px;
                height: 120px;
            }

            .top {
                padding: 10px;
            }
        }
    </style>
    @endpush
    <div class="container-fluid py-3">
        <div class="border my-2 row">
            <div class="col-xl-6 row d-flex align-items-center">
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
            </div>
            <div class="col-xl-6 d-flex align-items-center justify-content-end">
                <a href="{{route('data.siswa.create')}}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Tambah Data
                </a>
            </div>
        </div>
        <div class="d-flex flex-column">
            <div class="d-flex w-100 mb-3">
            </div>
            <div class="table-responsive">
                <table class="table mt-2 table-striped table-bordered" id="akun-siswa">
                    <thead class="text-light table-dark mt-2"></thead>
                    <tbody>
                        <!-- Data akan diisi oleh DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        var userRoute = "{{ route('data.siswa.single', ['id' => ':id']) }}";
        var deleteRoute = "{{ route('data.siswa.delete', ['id' => ':id']) }}";
        // var idDelete = '';
        $(document).ready(() => {
            // Inisialisasi DataTables
            let akunSiswaTable = $('#akun-siswa').DataTable({
                processing: true,
                pageLength: 50,
                serverSide: true,
                autoFill: false,
                ajax: {
                    url: '{{route('akun.siswa.get')}}',
                },
                columns: [
                    {
                        data: null,
                        title: 'No',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'siswa.nisn', title: 'NISN Siswa'},
                    {data: 'siswa.name', title: 'Nama Siswa'},
                    {data: 'siswa.kelas.name', title: 'Kelas'},
                    {data: 'siswa.jurusan.name', title: 'Jurusan'},
                    {
                        data: 'action',
                        title: 'Aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="btn-group">
                                    <a href="{{route('data.siswa.edit', '')}}/ ${row.id}" class="btn btn-sm btn-primary info-btn" data-id="${row.id}">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}" onclick="confirmDelete(${row.id})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ]
            });

            // Reset form saat modal ditutup
            $('#addmodal').on('hidden.bs.modal', function () {
                $('#siswaForm')[0].reset();
                $('#siswaForm').removeClass('was-validated');
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();
            });

            // Handle submit form
            $('#siswaForm').on('submit', function(e) {
                e.preventDefault();

                // Validasi form
                if (this.checkValidity() === false) {
                    e.stopPropagation();
                    $(this).addClass('was-validated');
                    return;
                }

                // Mengumpulkan data dari form
                const formData = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    nama: $('#nama').val(),
                    username: $('#username').val(),
                    kelas: $('#kelas').val(),
                    jurusan: $('#jurusan').val(),
                    password: $('#password').val(),
                    nisn: $('#nisn').val(),
                };

                // Kirim data via AJAX
                $.ajax({
                    url: '{{route('akun.siswa.store')}}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 200) {

                            showNotifCreate('Data Siswa berhasil Dibuat', 'success')
                            $('#addmodal').modal('hide');
                            // Refresh tabel
                            akunSiswaTable.ajax.reload();
                        } else {
                            showNotifCreate(response.message, 'alert')
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validasi server gagal
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = '';

                            for (const field in errors) {
                                errorMessage += errors[field][0] + '\n';
                            }

                            alert('Validasi gagal:\n' + errorMessage);
                        } else {
                            alert('Terjadi kesalahan server. Silakan coba lagi.');
                        }
                    }
                });
            });

            $('#deleteData').submit(function(e) {
                e.preventDefault()

                const formData = new FormData(this)
                const submitBtn = $('#submitBtn')

                submitBtn.prop('disabled', true)

                $.ajax({
                    url: deleteRoute.replace(':id', $('#idSiswa').val()),
                    type: 'DELETE',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response){
                        if(response.success){
                            console.log('data dihapus')

                            showNotifCreate('Data Siswa Dihapus', 'success')
                            $('#confirmDelete').modal('hide')
                            akunSiswaTable.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan saat mengupload!';
                        console.log(xhr)

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // Handle validation errors
                            const errors = xhr.responseJSON.errors;
                            if (errors.image) {
                                errorMessage = errors.image[0];
                            } else if (xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                        }

                    }
                })
            })
        });

        function infoSiswa(id){
            $('#infoSiswaModal').modal('show')
            loadImageFromLaravel(id)
        }

        function loadImageFromLaravel(id){
            var url = userRoute.replace(':id', id)

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    if(response.success){
                        // displayImage(response.image)
                        // console.log(response.)
                        $('#foto-guru').attr('src', response.image)
                        $('#nama-display').val(response.name)
                        $('#nisn-display').val(response.nisn)
                        $('#email-display').val(response.email)
                        $('#kelas-display').val(response.kelas)
                        $('#jurusan-display').val(response.jurusan)
                    }else{
                        console.log('ada yang salah')
                    }
                },
                error: function(xhr, status, error){
                    console.error("Error " + error)
                    alert("an error from request")
                }
            })
        }

        function confirmDelete(id){
            $('#confirmDelete').modal('show')
            $('#idSiswa').val(id)
        }

    </script>
    @endpush
</x-layouts.app>
