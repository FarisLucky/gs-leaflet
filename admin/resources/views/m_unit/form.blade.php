@push('css')
    <link rel="stylesheet" href="{{ asset('/dist/libs/toastr/toastr.css') }}">
@endpush
<div class="mb-1 p-3 border rounded">
    <div class="mb-1">
        @if (session()->get('success'))
            <div id="msg_notif" data-val="{{ session()->get('success') }}"></div>
        @endif
        <form action="{{ route('m_unit.store') }}" method="POST" id="mUnit_form">
            @csrf
            @method('POST')
            <div class="row align-items-end">
                <div class="col-md-12 mb-1">
                    <label class="form-label" for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama"
                        placeholder="Ruang Geneeral" />
                    @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md mb-1 text-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('javascript')
    <script src="{{ asset('dist/libs/toastr/toastr.js') }}"></script>
    <script>
        let msg = $('#msg_notif').attr('data-val')
    </script>
@endpush
