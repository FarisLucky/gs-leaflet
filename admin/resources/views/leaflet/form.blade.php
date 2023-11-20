@push('css')
    <link rel="stylesheet" href="{{ asset('/dist/libs/toastr/toastr.css') }}">
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
        <form action="{{ route('leaflets.store') }}" method="POST" id="leaflet_form">
            @csrf
            @method('POST')
            <div class="row align-items-end">
                <div class="col-md-3 mb-1">
                    <label class="form-label" for="judul">Judul</label>
                    <input type="text" class="form-control" name="judul" id="judul" placeholder="Nama" />
                    @error('judul')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-3 mb-1">
                    <label class="form-label" for="unit">Unit</label>
                    <select name="unit" id="unit" class="form-select">
                        <option value="">-- Pilih Unit --</option>
                        <option value="R.MATERNAL">R. MATERNAL</option>
                        <option value="R.NEO">R. NEO</option>
                        <option value="R.GENERAL">R. GENERAL</option>
                        <option value="R.ANAK">R. ANAK</option>
                        <option value="GIZI">GIZI</option>
                    </select>
                    @error('unit')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-3 mb-1">
                    <label class="form-label" for="deskripsi">Deskripsi</label>
                    <input type="text" class="form-control" name="desc" id="desc" placeholder="Deskripsi" />
                    @error('desc')
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
    <script>
        let msg = $('#msg_notif').attr('data-val')

        // if (msg !== '') {
        //     toastr.success(msg)
        // }

        // $(function() {

        //     const selector = document.querySelector('.filepond')
        //     const upload_url = selector.getAttribute('data-url')
        //     // File Pond
        //     FilePond.registerPlugin(
        //         FilePondPluginFileValidateSize,
        //         FilePondPluginFileValidateType,
        //         FilePondPluginImageExifOrientation,
        //         FilePondPluginImagePreview
        //         // FilePondPluginPdfPreview
        //     );

        //     FilePond.setOptions({
        //         allowImagePreview: true,
        //         imagePreviewMinHeight: 100,
        //         imagePreviewMinWidth: 100,
        //     });

        //     // Select the file input and use create() to turn it into a pond
        //     const pdfValidateType = {
        //         acceptedFileTypes: ['image/*'],
        //         labelFileTypeNotAllowed: 'File yang diupload harus Gambar'
        //     };
        //     const sizeValidationType = {
        //         allowFileSizeValidation: true,
        //         maxFileSize: '5MB',
        //         labelMaxFileSizeExceeded: 'File terlalu besar',
        //         labelMaxFileSize: 'Maksimal {filesize}'
        //     }
        //     let usingOnSubmit = {
        //         storeAsFile: true,
        //         instantUpload: false, // tanpa langsung diupload
        //         allowProcess: false
        //     };
        //     file = FilePond.create(selector, Object.assign({}, pdfValidateType, sizeValidationType, usingOnSubmit));
        // });
    </script>
@endpush
