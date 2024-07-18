<x-app-layout>
    @push('styles')
    @endpush

    <div class="content">
        <div class="content-heading d-flex justify-content-between align-items-center">
            <span>Tambah Peserta Baru</span>
            <div class="space-x-1">
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-content p-4">
                <form method="POST" action="{{ route('admin.user.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <x-input-field type="text" id="nim" name="nim" label="NIM" :required="true"/>
                            <x-input-field type="text" id="email" name="email" label="Alamat Email" :required="true"/>
                            <x-input-field type="password" id="password" name="password" label="Password" :required="true"/>
                        </div>
                        <div class="col-md-6">
                            <x-input-field type="text" id="nama" name="nama" label="Nama Lengkap" :required="true"/>
                            <x-input-field type="text" id="hp" name="hp" label="No HP" :required="true"/>
                            <x-input-field type="password" id="password_conf" name="password_conf" label="Konfirmasi Password" :required="true"/>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check me-1"></i>
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="/js/plugins/flatpickr/flatpickr.min.js"></script>
    <script src="/js/plugins/flatpickr/l10n/id.js"></script>
    <script src="/js/plugins/ckeditor5-classic/build/ckeditor.js"></script>
    <script>
        
        $("#field-tgl_lahir").flatpickr({
            altInput: true,
            altFormat: "d M Y",
            dateFormat: "Y-m-d",
            locale : "id",
        });
    </script>
    @endpush
</x-app-layout>

