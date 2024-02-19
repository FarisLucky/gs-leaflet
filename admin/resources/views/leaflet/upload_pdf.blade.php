<div class="modal fade" id="uploadPdf" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <div class="text-end">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="mb-1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <form action="#" method="POST" id="formUpload" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-1">
                                        <h5 class="mb-0">Upload File</h5>
                                    </div>
                                    <div class="mb-1">
                                        <div id="urlUpload" data-url="#"></div>
                                        <input type="file" class="form-control filepond-pdf" name="upload"
                                            id="upload" placeholder="Deskripsi" data-url="#" />
                                        @error('upload')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('javascript')
    <script src="https://unpkg.com/filepond-plugin-pdf-preview/dist/filepond-plugin-pdf-preview.min.js"></script>
    <script>
        var filepondPDF = null

        function filepondInitPDF() {
            const selectorPDF = document.querySelector('.filepond-pdf');
            const upload_url = selectorPDF.getAttribute('data-url')

            // File Pond
            FilePond.registerPlugin(
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize,
                FilePondPluginPdfPreview
            );

            let options = {
                allowPdfPreview: true,
                pdfPreviewHeight: 400,
                pdfComponentExtraParams: 'toolbar=0&view=fit&page=1',
                allowFileSizeValidation: true,
                maxFileSize: '2MB',
                acceptedFileTypes: ['application/pdf'],
                labelFileTypeNotAllowed: 'File yang diupload harus PDF',
                allowMultiple: true,
            }

            filepond = FilePond.create(selectorPDF, options);

            return filepond
        }
    </script>
    <script>
        let modalElPDF = document.querySelector('#uploadPdf');
        let modalPDF = new bootstrap.Modal(modalElPDF);

        modalEl.addEventListener('hide.bs.modal', function(event) {})

        function filepondPDFOptions(url) {
            filepondPDF.setOptions({
                files: null,
                instantUpload: false,
                server: {
                    process: {
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        onload: (response) => {
                            console.log(JSON.parse(response))
                        },
                    },
                },
            })
        }
    </script>
@endpush
