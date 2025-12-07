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
    </style>
    @endpush

    <div class="content-card">
        <form action="">
            @csrf
            <div class="form-group row mb-5">
                <div class="col">
                    <label class="form-label" for="from_date">Mulai Tanggal</label>
                    <input class="form-control" type="date" name="from_date" id="from_date">
                </div>
                <div class="col">
                    <label class="form-label" for="util_date">Sampai Tanggal</label>
                    <input class="form-control" type="date" name="until_date" id="until_date">
                </div>
            </div>
            <div class="form-group row mb-5">
                <div class="col">
                    <label class="form-label" for="jenis">Jenis</label>
                    <select class="form-control" name="jenis" id="jenis">
                        <option value="sakit">Sakit</option>
                        <option value="datang_terlambat">Datang Terlambat</option>
                        <option value="pulang_awal">Pulang Awal</option>
                        <option value="lain_lain">Lain - lain</option>
                    </select>
                </div>
                <div class="col">
                    <label class="form-label" for="keperluan">Untuk Keperluan</label>
                    <input class="form-control" type="text" name="keperluan" id="keperluan">
                </div>
            </div>
            <div class="form-group mb-5">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea class="form-control" name="catatan" id="catatan" rows="10"></textarea>
            </div>
            <div class="form-group mb-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Upload File Pendukung</label>
                            <div class="preview-zone hidden">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                    </div>
                                    <div class="box-body"></div>
                                </div>
                            </div>
                            <div class="dropzone-wrapper">
                                <div class="dropzone-desc">
                                    <i class="glyphicon glyphicon-download-alt"></i>
                                    <p>Choose an image file or drag it here.</p>
                                </div>
                                <input type="file" name="img_logo" class="dropzone">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row d-flex align-items-center justify-content-end">
                <div class="col-xl-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-primary">Ajukan</button>
                </div>
            </div>
        </form>
    </div>

    @push('script')
    <script>
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
    </script>
    @endpush
</x-layouts.app>
