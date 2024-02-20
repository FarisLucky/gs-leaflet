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
        <div class="mb-2">
            @include('leaflet.form')
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
                                        <th>Tgl Dibuat</th>
                                        <th>Judul</th>
                                        <th>Deskripsi</th>
                                        <th>Unit</th>
                                        <th>PDF</th>
                                        <th>IMG</th>
                                        <th style="width: 8%">Aksi</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($leaflets as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                                <td>{{ $item->judul }}</td>
                                                <td>{{ $item->desc }}</td>
                                                <td>{{ $item->unit }}</td>
                                                <td>
                                                    {{-- {{ dd($item) }} --}}
                                                    @if (\Illuminate\Support\Facades\Storage::disk('public')->exists(optional($item->urlFileJenis)->fullUrl))
                                                        <a href="{{ route('pdf_file', ['id' => $item->urlFileJenis->id]) }}"
                                                            target="_blank" class="link-primary">
                                                            Lihat
                                                        </a>
                                                    @else
                                                        <a href="{{ route('leaflet.showFile', ['id' => $item->id]) }}"
                                                            class="link-primary upload-pdf"
                                                            data-url="{{ route('leaflet.upload_file', ['id' => $item->id, 'jenis' => 'DOWNLOAD']) }}">
                                                            <i class="ti ti-pencil mb-1"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('leaflet.showFile', ['id' => $item->id, 'jenis' => 'VIEW']) }}"
                                                        class="link-success upload"
                                                        data-url-update="{{ route('leaflet.upload_file', ['id' => $item->id, 'jenis' => 'VIEW']) }}"
                                                        data-datatable="{{ route('api.leaflet.data_file', ['idLeaflet' => $item->id]) }}">
                                                        <i class="ti ti-file-upload mb-1"></i>
                                                    </a>
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
    @include('leaflet.upload_img')
    @include('leaflet.upload_pdf')
@endsection
@prepend('javascript')
    <script src="{{ asset('dist/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('dist/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('dist/libs/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('dist/libs/filepond/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script src="{{ asset('dist/libs/filepond/filepond-plugin-image-preview.js') }}"></script>
@endprepend
@push('javascript')
    <script>
        $(function() {
            table = $('#leaflet').DataTable({
                order: [
                    [1, 'desc']
                ],
                "fnInitComplete": function() {
                    hideLoader()
                }
            })

            filepondVar = filepondInit()
            filepondPDF = filepondInitPDF()

        });

        $('#leaflet tbody').on('click', '.edit', function(e) {
            e.preventDefault();

            let data = table.row($(this).closest('tr')).data();
            let url = $(this).attr('href');
            $('#leaflet_form input[name="judul"]').val(data[2]);
            $('#leaflet_form select[name="unit"]').val(data[3]).change();
            $('#leaflet_form input[name="desc"]').val(data[4]);
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

            filepondIMGOptions(urlUpdate)

            modal.show()
        });
        $('#leaflet tbody').on('click', '.upload-pdf', function(e) {
            e.preventDefault();

            let url = $(this).attr('data-url')

            filepondPDFOptions(url)

            modalPDF.show()
        });
    </script>
@endpush
