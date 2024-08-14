<x-landing-layout>
    <div class="content content-full">
        <div class="py-4 text-center">
            <h2 class="fw-bold mb-2">
                Program Saya
            </h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="block block-rounded">
                    <div class="block-content p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <x-field-read label="Kode Pendaftaran" value="{{ $data->kode }}"/>
                                <x-field-read label="Program" value="{{ $data->program->nama }}"/>
                                <x-field-read label="Tanggal" value="{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}"/>
                                <x-field-read label="Status">

                                    <x-slot name="value">
                                        @if($data->status == 'pending')
                                            <span class="badge bg-warning px-3">Pending</span>
                                        @elseif($data->status == 'terima')
                                            <span class="badge bg-success px-3">Diterima</span>
                                        @elseif($data->status == 'tolak')
                                            <span class="badge bg-danger px-3">Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary px-3">Batal</span>
                                        @endif
                                    </x-slot>
                                </x-field-read>
                            </div>
                            <div class="col-md-6">
                                <x-field-read label="File CV">
                                    <x-slot name="value">
                                        <a href="{{ $data->cv }}" target="_blank" class="btn btn-sm btn-primary">
                                            Lihat CV
                                        </a>
                                    </x-slot>
                                </x-field-read>
                                <x-field-read label="File KTP">
                                    <x-slot name="value">
                                        <a href="{{ $data->ktp }}" target="_blank" class="btn btn-sm btn-primary">
                                            Lihat KTP
                                        </a>
                                    </x-slot>
                                </x-field-read>
                                <x-field-read label="File Transkrip Nilai">
                                    <x-slot name="value">
                                        <a href="{{ $data->transkrip }}" target="_blank" class="btn btn-sm btn-primary">
                                            Lihat Transkrip Nilai
                                        </a>
                                    </x-slot>
                                </x-field-read>
                                <x-field-read label="File Asuransi">
                                    <x-slot name="value">
                                        <a href="{{ $data->asuransi }}" target="_blank" class="btn btn-sm btn-primary">
                                            Lihat Asuransi
                                        </a>
                                    </x-slot>
                                </x-field-read>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
        <script>
            $('#datatable').DataTable({
                dom : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            });
        </script>
    @endpush
</x-landing-layout>