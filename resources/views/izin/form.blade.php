<x-layouts.app title="Pengajuan Izin">
    @push('style')
    <style>
        .container {
            padding: 50px 200px;
        }

        .box {
            position: relative;
            background: #ffffff;
            width: 100%;
        }

        .box-header {
            color: #444;
            display: block;
            padding: 10px;
            position: relative;
            border-bottom: 1px solid #f4f4f4;
            margin-bottom: 10px;
        }

        .box-tools {
            position: absolute;
            right: 10px;
            top: 5px;
        }

        .dropzone-wrapper {
            border: 2px dashed #91b0b3;
            color: #92b0b3;
            position: relative;
            height: 150px;
        }

        .dropzone-desc {
            position: absolute;
            margin: 0 auto;
            left: 0;
            right: 0;
            text-align: center;
            width: 40%;
            top: 50px;
            font-size: 16px;
        }

        .dropzone,
        .dropzone:focus {
            position: absolute;
            outline: none !important;
            width: 100%;
            height: 150px;
            cursor: pointer;
            opacity: 0;
        }

        .dropzone-wrapper:hover,
        .dropzone-wrapper.dragover {
            background: #ecf0f5;
        }

        .preview-zone {
            text-align: center;
        }

        .preview-zone .box {
            box-shadow: none;
            border-radius: 0;
            margin-bottom: 0;
        }

        /* Tambahan untuk loading state */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-loading:after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: button-loading-spinner 1s ease infinite;
        }

        @keyframes button-loading-spinner {
            from {
                transform: rotate(0turn);
            }
            to {
                transform: rotate(1turn);
            }
        }
    </style>
    @endpush

    <div class="content-card">
        <form action="{{ route('siswa.izin.post') }}" method="POST" id="izinForm" enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-5">
                <div class="col">
                    <label class="form-label" for="from_date">Mulai Tanggal</label>
                    <input class="form-control" type="date" name="from_date" id="from_date" min="{{ now()->toDateString() }}" required>
                </div>
                <div class="col">
                    <label class="form-label" for="until_date">Sampai Tanggal</label>
                    <input class="form-control" type="date" name="until_date" id="until_date" min="{{ now()->toDateString() }}" required>
                </div>
            </div>
            <div class="form-group row mb-5">
                <div class="col">
                    <label class="form-label" for="jenis">Jenis</label>
                    <select class="form-control" name="jenis" id="jenis" required>
                        <option value="sakit">Sakit</option>
                        <option value="datang_terlambat">Datang Terlambat</option>
                        <option value="pulang_awal">Pulang Awal</option>
                        <option value="lain_lain">Lain - lain</option>
                    </select>
                </div>
                <div class="col">
                    <label class="form-label" for="keperluan">Untuk Keperluan</label>
                    <input class="form-control" type="text" name="keperluan" id="keperluan" required>
                </div>
            </div>
            <div class="form-group mb-5">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea class="form-control" name="catatan" id="catatan" rows="10" required></textarea>
            </div>
            <div class="form-group mb-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Upload File Pendukung</label>
                            <div class="preview-zone hidden">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <div class="box-tools">
                                            <button type="button" class="btn btn-danger btn-xs remove-preview">
                                                <i class="fa fa-times"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body"></div>
                                </div>
                            </div>
                            <div class="dropzone-wrapper">
                                <div class="dropzone-desc">
                                    <i class="glyphicon glyphicon-download-alt"></i>
                                    <p>Choose an image file or drag it here.</p>
                                </div>
                                <input type="file" name="file_pendukung" class="dropzone" accept="image/*,.pdf,.doc,.docx">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row d-flex align-items-center justify-content-end">
                <div class="col-xl-6 d-flex align-items-center justify-content-end">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Ajukan</button>
                </div>
            </div>
        </form>
    </div>

    @push('script')
    <script>
        $(document).ready(function() {
            // showNotifCreate('success', 'wedoss')
            var inputField = $('.dropzone-wrapper')

            function readFile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var htmlPreview =
                            '<img width="200" src="' + e.target.result + '" />' +
                            '<p>' + input.files[0].name + '</p>';
                        var wrapperZone = $(input).parent();
                        var previewZone = $(input).parent().parent().find('.preview-zone');
                        var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');

                        wrapperZone.removeClass('dragover');
                        previewZone.removeClass('hidden');
                        boxZone.empty();
                        boxZone.append(htmlPreview);
                    };

                    reader.readAsDataURL(input.files[0]);

                    inputField.addClass('hidden')
                }
            }

            function reset(e) {
                e.wrap('<form>').closest('form').get(0).reset();
                inputField.removeClass('hidden')
                e.unwrap();
            }

            $(".dropzone").change(function () {
                readFile(this);
            });

            $('.dropzone-wrapper').on('dragover', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });

            $('.dropzone-wrapper').on('dragleave', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });

            $('.remove-preview').on('click', function () {
                var boxZone = $(this).parents('.preview-zone').find('.box-body');
                var previewZone = $(this).parents('.preview-zone');
                var dropzone = $(this).parents('.form-group').find('.dropzone');
                boxZone.empty();
                previewZone.addClass('hidden');
                reset(dropzone);
            });

            // Form submission dengan AJAX
            $('#izinForm').on('submit', function(e) {
                e.preventDefault();

                var submitBtn = $('#submitBtn');
                var originalText = submitBtn.text();

                // Tampilkan loading state
                submitBtn.addClass('btn-loading');
                submitBtn.prop('disabled', true);
                submitBtn.text('Mengajukan...');

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Reset loading state
                        submitBtn.removeClass('btn-loading');
                        submitBtn.prop('disabled', false);
                        submitBtn.text(originalText);

                        if (response.status === 200) {
                            // Tampilkan pesan sukses
                            showNotifCreate('success', 'Izin berhasil dikirim');

                            // Reset form
                            $('#izinForm')[0].reset();

                            // Reset preview file
                            $('.preview-zone').addClass('hidden');
                            $('.preview-zone .box-body').empty();
                            inputField.removeClass('hidden');
                        } else {
                            alert('Terjadi kesalahan: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        // Reset loading state
                        submitBtn.removeClass('btn-loading');
                        submitBtn.prop('disabled', false);
                        submitBtn.text(originalText);

                        if (xhr.status === 422) {
                            // Validasi error
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';

                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '\n';
                            });

                            alert('Validasi gagal:\n' + errorMessage);
                        } else {
                            alert('Terjadi kesalahan pada server. Silakan coba lagi.');
                        }
                    }
                });
            });
        });
    </script>
    @endpush
</x-layouts.app>
