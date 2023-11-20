@extends('layouts.layout')

@section('title', 'Leaflet')
@push('css')
    <link href="{{ asset('dist/libs/filepond/filepond-plugin-image-preview.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/libs/filepond/filepond.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/dist/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/dist/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <style>
        .filepond--credits {
            display: none
        }
    </style>
@endpush
@section('content')

    <div class="container-xxl flex-grow-1">
        <!-- Basic Layout -->
        <div class="row mb-1">
            <div class="col-xl">
                @include('leaflet.form')
            </div>
        </div>
        <div class="row">
            <!-- Website Analytics -->
            <div class="col-lg-12 mb-1">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-1">Kumpulan Leaflet</h5>
                                <div>
                                    @include('components.notification')
                                </div>
                            </div>
                            <div class="col-12">
                                <table class="table leaflet" id="leaflet">
                                    <thead>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Deskripsi</th>
                                        <th>Unit</th>
                                        <th>file</th>
                                        <th style="width: 8%">Aksi</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($leaflets as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->judul }}</td>
                                                <td>{{ $item->unit }}</td>
                                                <td>{{ $item->desc }}</td>
                                                <td>
                                                    <div class="mb-1">
                                                        <a href="{{ route('leaflets.update', $item->id) }}"
                                                            class="link-info edit">
                                                            <i class="ti ti-eye mb-1"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="mb-1">
                                                        <a href="{{ route('leaflets.update', $item->id) }}"
                                                            class="link-info edit">
                                                            <i class="ti ti-pencil mb-1"></i>
                                                        </a>
                                                        <a href="{{ route('api.leaflet.destroy', ['id' => $item->id]) }}"
                                                            class="link-danger hapus">
                                                            <i class="ti ti-trash mb-1"></i>
                                                        </a>
                                                        <a href="{{ route('leaflet.showFile', ['id' => $item->id]) }}"
                                                            class="link-success upload"
                                                            data-url-update="{{ route('leaflet.upload_file', ['id' => $item->id], false) }}"
                                                            data-datatable="{{ route('api.leaflet.data_file', ['idLeaflet' => $item->id]) }}">
                                                            <i class="ti ti-file-upload mb-1"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('leaflet.modal_upload')
@endsection
@prepend('javascript')
    <script src="{{ asset('dist/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('dist/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('dist/libs/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('dist/libs/filepond/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script src="{{ asset('dist/libs/filepond/filepond-plugin-image-preview.js') }}"></script>
    <script>
        var filepondVar = null

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function filepondInit() {
            const selector = document.querySelector('.filepond');
            const upload_url = selector.getAttribute('data-url')

            // File Pond
            FilePond.registerPlugin(
                FilePondPluginFileValidateType,
                FilePondPluginImagePreview,
                FilePondPluginFileValidateSize
            );

            FilePond.setOptions({
                allowImagePreview: true,
                allowFileSizeValidation: true,
                maxFileSize: '2MB',
                acceptedFileTypes: ['image/*'],
                labelFileTypeNotAllowed: 'File yang diupload harus Gambar',
                allowMultiple: true,
            });

            filepond = FilePond.create(selector);

            return filepond
        }

        filepondVar = filepondInit()
    </script>
    <script>
        $(function() {
            table = $('#leaflet').DataTable()
        });

        $('#leaflet tbody').on('click', '.edit', function(e) {
            e.preventDefault();

            let data = table.row($(this).closest('tr')).data();
            let url = $(this).attr('href');
            $('#leaflet_form input[name="judul"]').val(data[1]);
            $('#leaflet_form select[name="unit"]').val(data[2]).change();
            $('#leaflet_form input[name="desc"]').val(data[3]);
            $('.form_title').text('Update');
            $('#leaflet_form').attr('action', url);
            $('#leaflet_form input[name="_method"]').val('PUT');
        });

        $('#leaflet tbody').on('click', '.hapus', function(e) {
            e.preventDefault();

            let urlData = $(this).attr('href');

            if (confirm('yakin dihapus ?')) {
                $.ajax({
                    type: "DELETE",
                    url: urlData
                }).then(response => {
                    window.location.reload()
                }).fail(err => {
                    console.log(err)
                    alert('Gagal Delete')
                });
            }
        });
        $('#leaflet tbody').on('click', '.upload', function(e) {
            e.preventDefault();

            const urlData = $(this).attr('href')
            const urlUpdate = $(this).attr('data-url-update')
            const urlDatatable = $(this).attr('data-datatable')
            let urls = $('#urlDatatable').attr('data-datatable', urlDatatable)

            $('#formUpload').attr('action', urlUpdate)

            filepondVar.files = null;

            filepondVar.setOptions({
                files: null,
                instantUpload: false,
                server: {
                    process: {
                        url: urlUpdate,
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

            modal.show()
        });
    </script>
@endprepend
