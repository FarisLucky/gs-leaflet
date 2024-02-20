@extends('layouts.layout')

@section('title', 'Unit')
@push('css')
    <link rel="stylesheet" href="{{ asset('/dist/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/dist/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endpush
@section('content')

    <div class="container-xxl flex-grow-1">
        <!-- Basic Layout -->
        <div class="mb-2">
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div>
                            @include('components.notification')
                        </div>
                    </div>
                    <div class="col-8">
                        <table class="table border rounded" id="mUnit">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tgl Dibuat</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($units as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="mb-1">
                                                <a href="{{ route('m_unit.update', $item->id) }}" class="link-info edit">
                                                    <i class="ti ti-pencil mb-1"></i>
                                                </a>
                                                <a href="{{ route('api.m_unit.destroy', $item->id) }}"
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
                    <div class="col-4">
                        @include('m_unit.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            table = $('#mUnit').DataTable({
                "fnInitComplete": function() {
                    hideLoader()
                }
            })

        });

        $('#mUnit tbody').on('click', '.edit', function(e) {
            e.preventDefault();

            let data = table.row($(this).closest('tr')).data();
            let url = $(this).attr('href');
            $('#mUnit_form input[name="nama"]').val(data[1]);
            $('#mUnit_form').attr('action', url);
            $('#mUnit_form input[name="_method"]').val('PUT');
        });

        $('#mUnit tbody').on('click', '.hapus', function(e) {
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
    </script>
@endpush
