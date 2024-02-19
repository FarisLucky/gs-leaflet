<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <div class="text-end">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="mb-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="urlDatatable" data-datatable="#"></div>
                            <table class="table" id="fileTable">
                                <thead>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th width="20%">Urut</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <form action="#" method="POST" id="formUpload" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-1">
                                        <h5 class="mb-0">Upload Gambar</h5>
                                    </div>
                                    <div class="mb-1">
                                        <div id="urlUpload" data-url="#"></div>
                                        <input type="file" class="form-control filepond-img" name="upload"
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
    <script>
        var filepondVar = null

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function filepondInit() {
            const selectorImg = document.querySelector('.filepond-img');
            const upload_url = selectorImg.getAttribute('data-url')

            // File Pond
            FilePond.registerPlugin(
                FilePondPluginFileValidateType,
                FilePondPluginImagePreview,
                FilePondPluginFileValidateSize
            );

            let options = {
                allowImagePreview: true,
                allowFileSizeValidation: true,
                maxFileSize: '2MB',
                acceptedFileTypes: ['image/*'],
                labelFileTypeNotAllowed: 'File yang diupload harus Gambar',
                allowMultiple: true,
            };

            filepond = FilePond.create(selectorImg, options);

            return filepond
        }
    </script>
    <script>
        let modalEl = document.querySelector('#uploadModal');
        let modal = new bootstrap.Modal(modalEl);
        let tableModal = null;

        function initializeDTable(table, callback) {
            return $(table).DataTable({
                processing: true,
                serverSide: true,
                language: {
                    processing: '<i class="fas fa-circle-notch fa-spin fa-fw"></i>'
                },
                ajax: callback(),
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        searchable: false
                    },
                    {
                        data: 'order',
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        searchable: false
                    },
                    {
                        data: 'aksi',
                        searchable: false
                    },
                ],
                "fnInitComplete": function(oSettings, json) {
                    console.log('xhr completed!')
                },
                "responsive": true,
                "autoWidth": false,
            });
        }

        $('#fileTable').on('click', '.edit', function(e) {
            e.preventDefault();

            let urlData = $(this).attr('href');
            filepondVar.files = null;
            filepondVar.addFile(urlData);

        });

        $('#fileTable').on('click', '.hapus', function(e) {
            e.preventDefault();

            let urlData = $(this).attr('href');

            if (confirm('yakin dihapus ?')) {
                $.ajax({
                    type: "DELETE",
                    url: urlData,
                }).then(rsponse => {
                    filepondVar.files = null;
                    alert('Berhasil')
                    tableModal.row(this).remove().draw(false)
                }).fail(err => {
                    alert('Gagal Delete Order')
                });
            }
        });

        $('#fileTable').on('keypress', '.updateOrder', function(e) {
            let urlData = $(this).attr('data-url');
            if (e.which == 13) {
                $.ajax({
                    type: "PUT",
                    url: urlData,
                    data: {
                        order: $(this).val()
                    },
                }).then(rsponse => {
                    tableModal.row(this).remove().draw(false)
                }).fail(err => {
                    alert('Gagal Update Order')
                });
            }
        });

        modalEl.addEventListener('show.bs.modal', function(event) {
            let urls = $('#urlDatatable').attr('data-datatable');
            tableModal = initializeDTable('#fileTable', () => {
                return {
                    url: urls
                }
            })
        })

        modalEl.addEventListener('hide.bs.modal', function(event) {
            tableModal.destroy()
        })

        function filepondIMGOptions(url) {
            filepondVar.setOptions({
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
                            if (JSON.parse(response).code === 200) {
                                console.log('berhasil')
                                tableModal.ajax.reload()
                            }
                        },
                    },
                },
            })
        }
    </script>
@endpush
