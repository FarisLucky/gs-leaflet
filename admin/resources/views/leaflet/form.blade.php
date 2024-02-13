@push('css')
    <link rel="stylesheet" href="{{ asset('/dist/libs/toastr/toastr.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.30.6/filepond.css">
@endpush
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 form_title">Tambah</h5>
        <small class="text-muted float-end">LEAFLET</small>
    </div>
    <div class="card-body">
        @if (session()->get('success'))
            <div id="msg_notif" data-val="{{ session()->get('success') }}"></div>
        @endif
        <form action="{{ route('leaflets.store') }}" method="POST" id="leaflet_form" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row align-items-end">
                <div class="col-md-3 mb-1">
                    <label class="form-label" for="judul">Judul</label>
                    <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul"
                        value="{{ old('judul') }}" />
                    @error('judul')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-7 mb-1">
                    <label class="form-label" for="deskripsi">Deskripsi</label>
                    <input type="text" class="form-control" name="desc" id="desc" placeholder="Deskripsi"
                        value="{{ old('desc') }}" />
                    @error('desc')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-2 mb-1">
                    <label class="form-label" for="unit">Unit</label>
                    @php
                        $units = ['R.MATERNAL', 'R.NEO', 'R.GENERAL', 'R.ANAK', 'GIZI'];
                    @endphp
                    <select name="unit" id="unit" class="form-select">
                        <option value="">-- Pilih Unit --</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit }}" {{ old('unit') === $unit ? 'selected' : '' }}>
                                {{ $unit }}</option>
                        @endforeach
                    </select>
                    @error('unit')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-12">
                    <input type="file" name="filepond" id="filepond">
                    @error('filepond')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md mb-1">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('javascript')
    <script src="{{ asset('dist/libs/toastr/toastr.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.30.6/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-pdf-preview/dist/filepond-plugin-pdf-preview.min.js"></script>
    <script>
        let msg = $('#msg_notif').attr('data-val')
        document.addEventListener("DOMContentLoaded", () => {
            const selector = document.querySelector('#filepond')
            const upload_url = selector.getAttribute('data-url')
            // File Pond
            FilePond.registerPlugin(
                FilePondPluginFileValidateSize,
                FilePondPluginFileValidateType,
                FilePondPluginPdfPreview
            );

            FilePond.setOptions({
                allowPdfPreview: true,
                pdfPreviewHeight: 200,
                pdfComponentExtraParams: 'toolbar=0&view=fit&page=1'
            });

            // Select the file input and use create() to turn it into a pond
            const pdfValidateType = {
                acceptedFileTypes: ['application/pdf'],
                labelFileTypeNotAllowed: 'File yang diupload harus PDF'
            };
            const sizeValidationType = {
                allowFileSizeValidation: true,
                maxFileSize: '5MB',
                labelMaxFileSizeExceeded: 'File terlalu besar',
                labelMaxFileSize: 'Maksimal {filesize}'
            }
            let usingOnSubmit = {
                storeAsFile: true,
                instantUpload: false, // tanpa langsung diupload
                allowProcess: false
            };
            file = FilePond.create(selector, Object.assign({}, pdfValidateType, sizeValidationType, usingOnSubmit));
        });
        $.ajax({
            type: "POST",
            url: "url",
            data: "data",
            dataType: "dataType",
            success: function(response) {

            }
        });
    </script>
@endpush
