<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="/js/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/js/plugins/flatpickr/flatpickr.min.css">
    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }
    </style>
    @endpush

    <div class="content">
        <div class="content-heading d-flex justify-content-between align-items-center">
            <span>{{ isset($data) ? 'Edit Program' : 'Tambah Program' }}</span>
            <div class="space-x-1">
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-content p-4">
                <form method="POST" action="{{ route('admin.program.store') }}" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                    <div class="col-6">
                        <x-input-field type="text" id="nama" name="nama" label="Nama Program" :required="true"/>
                        <x-select-field id="skema" placeholder="Pilih" name="skema" :options="[
                            ['label' => 'Onsite', 'value' => 'Onsite'],
                            ['label' => 'Remote', 'value' => 'Remote'],
                            ['label' => 'Terkadang Remote, Terkadang Onsite', 'value' => 'Terkadang Remote, Terkadang Onsite'],
                        ]" label="Skema Program" :required="true"/>
                        <x-input-field type="text" id="lokasi" name="lokasi" label="Lokasi" :required="true"/>
                        <x-input-field type="text" id="tgl_daftar" name="tgl_daftar" label="Periode Tgl Pendaftaran" :required="true"/>
                    </div>
                    <div class="col-6">
                        <x-select-field id="kategori" placeholder="Pilih" name="kategori_id" :options="$kategori" label="Kategori" :required="true"/>
                        <x-input-field type="number" id="kuota" name="kuota" label="Kuota" :required="true"/>
                        <x-input-field type="text" id="mitra" name="mitra" label="Nama Mitra" :required="true"/>
                        <x-input-field type="text" id="tgl_pelaksanaan" name="tgl_pelaksanaan" label="Periode Tgl Pelaksanaan" :required="true"/>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="field-deskripsi">Deskripsi</label>
                    <textarea class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                        id="field-deskripsi" name="deskripsi"
                        placeholder="Masukan deskripsi">{{ old('deskripsi') }}</textarea>
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
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
    <script src="/js/plugins/select2/js/select2.full.min.js"></script>
    <script src="/js/plugins/flatpickr/flatpickr.min.js"></script>
    <script src="/js/plugins/flatpickr/l10n/id.js"></script>
    <script src="/js/plugins/ckeditor5-classic/build/ckeditor.js"></script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script> --}}
    <script>
        
        ClassicEditor
        .create( document.querySelector('#field-deskripsi'))
        .catch( error => {
            console.error( error );
        } );
        
        $('#field-kategori').select2();
        $('#field-jadwal').select2({
            multiple : true,
        });
        
        $(".tgl").flatpickr({
            altInput: true,
            altFormat: "j F Y H:i",
            dateFormat: "Y-m-d H:i",
            locale : "id",
            enableTime: true,
            time_24hr: true
        });

        
        $("#field-tgl_daftar").flatpickr({
            altInput: true,
            altFormat: "d M Y",
            dateFormat: "Y-m-d",
            locale : "id",
            mode: "range"
        });

        
        $("#field-tgl_pelaksanaan").flatpickr({
            altInput: true,
            altFormat: "d M Y",
            dateFormat: "Y-m-d",
            locale : "id",
            mode: "range"
        });


        $(".time").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });


    </script>
    @endpush
</x-app-layout>

